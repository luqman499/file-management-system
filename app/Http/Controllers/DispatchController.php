<?php
namespace App\Http\Controllers;
use App\Http\Requests\DispatchRequest;
use App\Http\Requests\DispatchUpdateRequest;
use App\Models\Department;
use App\Models\Dispatch;
use App\Models\DispatchDetail;
use App\Models\DispatchDocument;
use App\Models\Flag;
use App\Models\Folder;
use App\Models\Office;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DispatchController extends Controller
{
    public function index()
    {
        $models = Dispatch::with('users', 'office', 'flag', 'folder',)
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

            // Handle file
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $fileName = 'dispatch_document_' . uniqid() . '.' . $attachment->getClientOriginalExtension();
                    $filePath = $attachment->move('documents', $fileName);
                    DispatchDocument::create([
                        'dispatch_id' => $model->id,
                        'title' => $attachment->getClientOriginalName(),
                        'file' => $filePath,
                        'status' => 0,
                    ]);
                }
            }
            // Handle selected users
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
                'dispatchDocuments',
                'dispatchDetails',
                'dispatchDetails.dispatchDetailDocument',
                'office',
                'folder',
                'flag',

            ])->find($id);
//            dd($dispatch->dispatchDocuments);
            $offices = Office::pluck('title', 'id');
            $users = User::with(['office:id,title', 'department:id,name'])
                ->get();
            return view('backend.website.dispatch.show', compact('dispatch', 'offices', 'users'));
        } catch (\Exception $e) {
            session()->flash('error', 'Dispatch not found: ' . $e->getMessage());
            return redirect()->route('dispatch.index');
        }
        //  $users = User::pluck('name', 'id');
        //  $details = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments' ,'dispatchDetailDocument')->find($id);
        //  return view('backend.website.dispatch.show', compact('details', 'users'));
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
            $model = Dispatch::find($id);
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
                    $filePath = $attachment->move('public/documents/', $fileName);

                    DispatchDocument::create([
                        'dispatch_id' => $model->id,
                        'file' => $filePath
                    ]);
                }
            }

            if ($request->filled('selected_users')) {
                $model->users()->sync($request->selected_users);
            } else {
                $model->users()->sync([]);
            }

            flash()->success('Dispatch updated successfully!');
            return redirect()->route('dispatch.index');
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
            return redirect()->route('dispatch.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete dispatch: ' . $e->getMessage());
            return back();
        }
    }

   public function updateStatus(Request $request, $id)
 {
        $dispatchDetail = DispatchDetail::find($id);
        $dispatchDetail->status = $request->status;
        $dispatchDetail->remark = $request->remark;
        $dispatchDetail->save();

        return redirect()->back()->with('success', 'Status updated successfully.');

 }

    //Assigned to me tasks
    public function assigned(){
        $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')->ofAssignedToMe()->get();
        return view('backend.website.inbox.assigned.index', compact('models'));
    }
    public function approved($id){
    $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')->ofApproved()->ofAssignedToMe()->get();
    return view('backend.website.inbox.approved.index', compact('models'));
 }
 public function rejected($id){
    $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')->ofRejected->ofAssignedToMe()->get();
    return view('backend.website.inbox.rejected.index', compact('models'));
 }
 public function returned($id){
    $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')->ofReturned->ofAssignedToMe()->get();
    return view('backend.website.inbox.returned.index', compact('models'));
 }
 public function recommended($id){
    $models = DispatchDetail::with('dispatch', 'dispatch.dispatchDocuments')->ofRecommended->ofAssignedToMe()->get();
    return view('backend.website.inbox.recommended.index', compact('models'));
}

}
