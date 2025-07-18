<?php
namespace App\Http\Controllers;
use App\Http\Requests\DispatchRequest;
use App\Http\Requests\DispatchUpdateRequest;
use App\Models\Department;
use App\Models\Dispatch;
use App\Models\DispatchDetail;
use App\Models\DispatchDetailDocument;
use App\Models\DispatchDocument;
use App\Models\Flag;
use App\Models\Folder;
use App\Models\Office;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Exceptions\UnauthorizedException;

class DispatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-dispatch')->only(['index', 'show']);
        $this->middleware('permission:view-all-tasks')->only(['allTasks']);
        $this->middleware('permission:view-assigned-tasks')->only(['assigned', 'approved', 'rejected', 'returned', 'recommended']);
        $this->middleware('permission:view-admin-inbox')->only(['adminInbox']);
        $this->middleware('permission:create-dispatch')->only(['create', 'store']);
        $this->middleware('permission:edit-dispatch')->only(['edit', 'update']);
        $this->middleware('permission:delete-dispatch')->only(['delete']);
        $this->middleware('permission:approve-task|reject-task|recommend-task|return-task')->only(['updateStatus']);
    }

    public function index()
    {
        $models = Dispatch::with('user', 'office', 'flag', 'folder')
            ->where('status', 0)
            ->get();
        return view('backend.website.dispatch.index', compact('models'));
    }

    public function create()
    {
        $flags = Flag::pluck('title', 'id');
        $offices = Office::pluck('title', 'id');
        $departments = Department::pluck('name', 'id');
        $folders = Folder::pluck('title', 'id');
        $users = User::select('id', 'name', 'cnic', 'contact', 'office_id', 'department_id')
            ->with(['office:id,title', 'department:id,name'])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name ?? 'N/A',
                    'cnic' => $user->cnic ?? 'N/A',
                    'contact' => $user->contact ?? 'N/A',
                    'office_id' => $user->office_id,
                    'department_id' => $user->department_id,
                    'office' => $user->office ? ['title' => $user->office->title ?? 'N/A'] : null,
                    'department' => $user->department ? ['name' => $user->department->name ?? 'N/A'] : null,
                ];
            });
        return view('backend.website.dispatch.create', compact('flags', 'offices', 'departments', 'folders', 'users'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = new Dispatch();
            $model->flag_id = $request->flag_id;
            $model->folder_id = $request->folder_id;
            $model->office_id = $request->office_id;
            $model->user_id = auth()->id();
            $model->title = $request->title;
            $model->dispatch_number = $request->dispatch_number;
            $model->file_number = $request->file_number;
            $model->description = $request->description;
            $model->date = $request->date;
            $model->time = $request->time;
            $model->send_to = $request->send_to;
            $model->received_from = $request->received_from;
            $model->status = $request->status ?? '0';
            $model->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $fileName = 'dispatch_document_' . uniqid() . '.' . $attachment->getClientOriginalExtension();
                    $filePath = $attachment->move('documents', $fileName);
                    DispatchDocument::create([
                        'dispatch_id' => $model->id,
                        'title' => $attachment->getClientOriginalName(),
                        'file' => 'documents/' . $fileName,
                        'status' => 0,
                    ]);
                }
            }
            if ($request->filled('selected_users')) {
                foreach ($request->selected_users as $user_id) {
                    DispatchDetail::create([
                        'dispatch_id' => $model->id,
                        'user_id' => $user_id,
                        'status' => 0,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Dispatch created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create dispatch: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $dispatch = Dispatch::with([
                'user',
                'dispatchDocuments',
                'dispatchDetails' => function($query) {
                    $query->latest();
                },
                'dispatchDetails.user',
                'dispatchDetails.dispatchDetailDocument',
                'office',
                'folder',
                'flag',
            ])->findOrFail($id);

            return view('backend.website.dispatch.show', [
                'dispatch' => $dispatch,
                'offices' => Office::pluck('title', 'id'),
                'users' => User::with(['office:id,title', 'department:id,name'])->get()
            ]);
        } catch (\Exception $e) {
            Log::error('Dispatch show error: ' . $e->getMessage());
            return redirect()->route('dispatches.index')->with('error', 'Dispatch not found');
        }
    }

    public function edit($id)
    {
        $model = Dispatch::find($id);
        $flags = Flag::pluck('title', 'id');
        $offices = Office::pluck('title', 'id');
        $departments = Department::pluck('name', 'id');
        $folders = Folder::pluck('title', 'id');
        $users = User::select('id', 'name', 'cnic', 'contact', 'office_id', 'department_id')
            ->with(['office:id,title', 'department:id,name'])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name ?? 'N/A',
                    'cnic' => $user->cnic ?? 'N/A',
                    'contact' => $user->contact ?? 'N/A',
                    'office_id' => $user->office_id,
                    'department_id' => $user->department_id,
                    'office' => $user->office ? ['title' => $user->office->title ?? 'N/A'] : null,
                    'department' => $user->department ? ['name' => $user->department->name ?? 'N/A'] : null,
                ];
            });

        return view('backend.website.dispatch.edit', compact('model', 'flags', 'offices', 'departments', 'folders', 'users'));
    }

    public function update(DispatchUpdateRequest $request, $id)
    {
        try {
            $model = Dispatch::findOrFail($id);
            $model->flag_id = $request->flag_id;
            $model->folder_id = $request->folder_id;
            $model->office_id = $request->office_id;
            $model->title = $request->title;
            $model->dispatch_number = $request->dispatch_number;
            $model->file_number = $request->file_number;
            $model->description = $request->description;
            $model->date = $request->date;
            $model->time = $request->time;
            $model->send_to = $request->send_to;
            $model->received_from = $request->received_from;
            $model->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $fileName = 'dispatch_document_' . uniqid() . '.' . $attachment->getClientOriginalExtension();
                    $filePath = $attachment->move('documents', $fileName);
                    DispatchDocument::create([
                        'dispatch_id' => $model->id,
                        'title' => $attachment->getClientOriginalName(),
                        'file' => 'documents/' . $fileName,
                        'status' => 0,
                    ]);
                }
            }

            if ($request->filled('selected_users')) {
                DispatchDetail::where('dispatch_id', $model->id)->delete();
                foreach ($request->selected_users as $user_id) {
                    DispatchDetail::create([
                        'dispatch_id' => $model->id,
                        'user_id' => $user_id,
                        'status' => 0,
                    ]);
                }
            }

            flash()->success('Dispatch updated successfully!');
            return redirect()->route('dispatches.index');
        } catch (\Exception $e) {
            flash()->error('Something went wrong: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function delete($id)
    {
        try {
            $model = Dispatch::find($id);
            $model->delete();
            session()->flash('success', 'Dispatch deleted successfully!');
            return redirect()->route('dispatches.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete dispatch: ' . $e->getMessage());
            return back();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'remark' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $plainText = strip_tags($value);
                        if (trim($plainText) === '') {
                            $fail('The remark field must contain meaningful text.');
                        }
                    },
                ],
                'status' => 'required|in:1,2,3,4',
                'attachment.*' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
                'selected_users' => 'required_if:status,4|array',
                'selected_users.*' => 'exists:users,id',
            ]);

            $dispatch = Dispatch::findOrFail($id);
            $status = $request->status;
            $selectedUsers = $request->selected_users ?? [];

            $permissionMap = [
                1 => 'approve-task',
                2 => 'reject-task',
                3 => 'return-task',
                4 => 'recommend-task',
            ];
            if (!auth()->user()->hasPermissionTo($permissionMap[$status])) {
                throw new UnauthorizedException(403, 'You do not have permission to perform this action.');
            }

            $remark = $request->remark;
            $remark = preg_replace('/<p>\s*(<br\s*\/?>)*\s*<\/p>/i', '', $remark);
            $remark = trim(strip_tags($remark)) !== '' ? $remark : null;

            $dispatchDetail = DispatchDetail::create([
                'dispatch_id' => $dispatch->id,
                'user_id' => auth()->id(),
                'remark' => $remark,
                'status' => $status,
            ]);

            if ($request->hasFile('attachment')) {
                foreach ($request->file('attachment') as $attachment) {
                    $fileName = 'dispatch_detail_document_' . uniqid() . '.' . $attachment->getClientOriginalExtension();
                    $filePath = $attachment->storeAs('documents', $fileName, 'public');
                    Log::info('Stored file path: ' . $filePath);
                    DispatchDetailDocument::create([
                        'dispatch_detail_id' => $dispatchDetail->id,
                        'title' => $attachment->getClientOriginalName(),
                        'file' => 'documents/' . $fileName,
                    ]);
                }
            }

            switch ($status) {
                case 4: // Recommended
                    foreach ($selectedUsers as $user_id) {
                        if (User::where('id', $user_id)->exists()) {
                            DispatchDetail::create([
                                'dispatch_id' => $dispatch->id,
                                'user_id' => $user_id,
                                'status' => 0,
                            ]);
                        }
                    }
                    break;

                case 3: // Returned
                    $previousDetail = DispatchDetail::where('dispatch_id', $dispatch->id)
                        ->where('id', '!=', $dispatchDetail->id)
                        ->where('user_id', '!=', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($previousDetail && $previousDetail->user_id) {
                        DispatchDetail::create([
                            'dispatch_id' => $dispatch->id,
                            'user_id' => $previousDetail->user_id,
                            'status' => 0,
                            'remark' => 'Returned for revision',
                        ]);
                    } else {
                        Log::warning('No previous user found for return', [
                            'dispatch_id' => $dispatch->id,
                            'current_user_id' => auth()->id(),
                        ]);
                    }
                    break;

                case 1: // Approved
                case 2: // Rejected
                    break;
            }

            DB::commit();
            return response()->json(['message' => 'Dispatch updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update dispatch:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json(['error' => 'Failed to update dispatch: ' . $e->getMessage()], 500);
        }
    }

    public function adminInbox()
    {
        $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')
            ->ofNeedsAdminAttention()
            ->whereHas('dispatch')
            ->get();
        Log::info('Admin inbox query:', ['count' => $models->count(), 'user_id' => auth()->id()]);
        return view('backend.website.inbox.admin.index', compact('models'));
    }

    public static function getSidebarCounts()
    {
        $counts = [
            'all' => 0,
            'returned' => 0,
            'rejected' => 0,
            'recommended' => 0,
            'approved' => 0,
            'assigned_to_me' => 0,
        ];

        if (auth()->user()->hasPermissionTo('view-all-tasks')) {
            $counts['all'] = DispatchDetail::where('user_id', auth()->id())->count();
        }
        if (auth()->user()->hasPermissionTo('view-assigned-tasks')) {
            $counts['returned'] = DispatchDetail::ofReturned()->where('user_id', auth()->id())->count();
            $counts['rejected'] = DispatchDetail::ofRejected()->where('user_id', auth()->id())->count();
            $counts['recommended'] = DispatchDetail::ofRecommended()->where('user_id', auth()->id())->count();
            $counts['approved'] = DispatchDetail::ofApproved()->where('user_id', auth()->id())->count();
            $counts['assigned_to_me'] = DispatchDetail::ofAssignedToMe()->count();
        }
        return $counts;
    }

    public function assigned()
    {
        $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')
            ->ofAssignedToMe()
            ->whereHas('dispatch')
            ->get();
        Log::info('Assigned tasks query:', ['count' => $models->count(), 'user_id' => auth()->id()]);
        return view('backend.website.inbox.assigned.index', compact('models'));
    }

    public function approved()
    {
        $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')
            ->ofApproved()
            ->where('user_id', auth()->id())
            ->whereHas('dispatch')
            ->get();
        Log::info('Approved tasks query:', ['count' => $models->count(), 'user_id' => auth()->id()]);
        return view('backend.website.inbox.approved.index', compact('models'));
    }

    public function rejected()
    {
        $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')
            ->ofRejected()
            ->where('user_id', auth()->id())
            ->whereHas('dispatch')
            ->get();
        Log::info('Rejected tasks query:', ['count' => $models->count(), 'user_id' => auth()->id()]);
        return view('backend.website.inbox.rejected.index', compact('models'));
    }

    public function returned()
    {
        $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')
            ->ofReturned()
            ->where('user_id', auth()->id())
            ->whereHas('dispatch')
            ->get();
        Log::info('Returned tasks query:', ['count' => $models->count(), 'user_id' => auth()->id()]);
        return view('backend.website.inbox.returned.index', compact('models'));
    }

    public function recommended()
    {
        $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')
            ->ofRecommended()
            ->where('user_id', auth()->id())
            ->whereHas('dispatch')
            ->get();
        Log::info('Recommended tasks query:', ['count' => $models->count(), 'user_id' => auth()->id()]);
        return view('backend.website.inbox.recommended.index', compact('models'));
    }

    public function allTasks()
    {
        $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')
            ->where('user_id', auth()->id())
            ->whereHas('dispatch')
            ->get();
        Log::info('All tasks query:', ['count' => $models->count(), 'user_id' => auth()->id()]);
        return view('backend.website.inbox.all.index', compact('models'));
    }
}

