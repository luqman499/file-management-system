<?php

namespace App\Http\Controllers;

use App\Models\Department;

use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\User;

class DepartmentController extends Controller
{
    // Display a listing of the departments.
    public function index()
    {
        $models = Department::all(); 
        return view('backend.website.primary_setting.department.index', compact('models')); // Passing data to view
    }

    public function create()
    {

        return view('backend.website.primary_setting.department.create'); // Load create form
    }

    public function store(DepartmentRequest $request)
    {
        $model = new Department();
        $model->name = $request->name;
        $model->code = $request->code;
        $model->save();
         
        return redirect()->route('department.index');
       
    }

    public function edit($id)
    {
        $model = Department::find($id);
        return view('backend.website.primary_setting.department.edit', compact('model'));

    }

    public function update(DepartmentUpdateRequest $request, $id)
{
        $model = Department::find($id);
        $model->name = $request->name;
        $model->code = $request->code;
        $model->save();
         
        return redirect()->route('department.index')->with('success', 'Department updated successfully!');
    }


    public function delete($id)
    {
        $model = Department::find($id);
        $model->delete();
        $model->save();
        
            return redirect()->route('department.index');
        }
}
