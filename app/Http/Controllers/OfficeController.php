<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeRequest;
use App\Http\Requests\OfficeUpdateRequest;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Office::all();
        return view('backend.website.primary_setting.office.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.website.primary_setting.office.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfficeRequest $request)
    {
        $model = new Office();
        $model->title = $request->title;
        $model->address = $request->address;
        $model->contact = $request->contact;
        $model->save();
         session()->flash('success', 'Office Create successfully!');
         return redirect()->route('office.index');

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
        $model = Office::find($id);
        return view('backend.website.primary_setting.office.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OfficeUpdateRequest $request, string $id)
    {
        $model = Office::find($id);
        $model->title = $request->title;
        $model->address = $request->address;
        $model->contact = $request->contact;
        $model->save();
        session()->flash('success', 'Office Update successfully!');
            return redirect()->route('office.index');


            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
            return back()->withInput();
        return redirect()->route('office.index');
    }

    /*
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $model = Office::find($id);
        $model->delete();

       flash()->success('Office deleted successfully!');
            return redirect()->route('office.index');
            flash()->error('Failed to delete office: ' . $e->getMessage());
    }
}
