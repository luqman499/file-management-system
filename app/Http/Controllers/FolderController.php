<?php

namespace App\Http\Controllers;

use App\Http\Requests\FolderRequest;
use App\Http\Requests\FolderupdateRequest;
use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Folder::all();
        return view('backend.website.primary_setting.folder.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.website.primary_setting.folder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FolderRequest $request)
    {
        $model = new Folder();
        $model->title = $request->title;
        $model->code = $request->code;
        $model->save();
            return redirect()->route('folder.index');
        return redirect()->route('folder.index');
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
        $model = Folder::find($id);
        return view('backend.website.primary_setting.folder.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FolderUpdateRequest $request, string $id)
    {
        $model = Folder::find($id);
        $model->title = $request->title;
        $model->code = $request->code;
        $model->save();
            return redirect()->route('folder.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $model = Folder::find($id);
        $model->delete();
           $model->save();
            return redirect()->route('folder.index');
       
    }
}
