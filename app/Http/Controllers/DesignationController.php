<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesignationRequest;
use App\Models\Designation;
use Illuminate\Http\Request;


class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $models = Designation::all();
         return view('backend.website.primary_setting.designation.index',compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.website.primary_setting.designation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesignationRequest $request)
    {
        $model = new Designation();
        $model->title = $request->title;
        $model->code = $request->code;
        $model->save();
          
        return redirect()->route('designation.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model =Designation::find($id);
        return view('backend.website.primary_setting.designation.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model = Designation::find($id);
        $model->title = $request->title;
        $model->code = $request->code;
        $model->save();
        
        return redirect()->route('designation.index')->with('success', 'Designation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $model=Designation::find($id);
        $model->delete();
            return redirect()->route('designation.index');
          
    }
}
