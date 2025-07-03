<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Department;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $models = User::with('department','office')->latest()->get();
     return view('backend.website.secondary_setting.user.index',compact('models'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::pluck('name','id');
        $offices = Office::pluck('title','id');
      return view('backend.website.secondary_setting.user.create',compact('departments','offices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $model = new User();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = Hash::make($request->password);
        $model->cnic = $request->cnic;
        $model->office_id = $request->office_id;
        $model->department_id = $request->department_id;
        $model->contact = $request->contact;

        if ($request->hasFile('image')) {
            $imageName = uniqid() . '_' . $request->image->getClientOriginalName();
            $path = $request->image->move('assets/user', $imageName);
            $model->image = $path;
        }

        $model ->save();

      session()->flash('success', 'User Update successfully!');
            return redirect()->route('user.index');

       
            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
            return back()->withInput();
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = User::with('department', 'office')->findOrFail($id);
        return view('backend.website.secondary_setting.user.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $model = User::with('department','office')->find($id);
    $departments = Department::pluck('name','id');
    $offices = Office::pluck('title','id');
    return view('backend.website.secondary_setting.user.edit',compact('model','departments','offices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $model = User::find($id);
        $model->name = $request->name;
         $model->email = $request->email;
         $model->password = Hash::make($request->password);
         $model->cnic = $request->cnic;
         $model->office_id = $request->office_id;
        $model->department_id = $request->department_id;
         $model->contact = $request->contact;
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '_' . $request->image->getClientOriginalName();
            $path = $request->image->move('assets/user', $imageName);
            $model->image = $path;
        }
        $model->save();
        return redirect()->route('office.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $model = User::find($id);
        $model->delete();
            return redirect()->route('user.index');
    }       
}
