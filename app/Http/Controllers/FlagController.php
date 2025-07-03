<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlagRequest;
use App\Http\Requests\FlagUpdateRequest;
use App\Models\Flag;
use Illuminate\Http\Request;

class FlagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Flag::all();
        return view('backend.website.primary_setting.flags.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.website.primary_setting.flags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FlagRequest $request)
    {
        $model = new Flag();
        $model->title = $request->title;
        $model->code = $request->code;
        $model->save();
            return redirect()->route('flag.index');
        return redirect()->route('flag.index');
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
        $model = Flag::find($id);
        return view('backend.website.primary_setting.flags.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FlagUpdateRequest $request, string $id)
    {
        $model = Flag::find($id);
        $model->title = $request->title;
        $model->code = $request->code;
        $model->save();
    
            return redirect()->route('flag.index');
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $model = Flag::find($id);
        $model->delete();
        $model->save();
            return redirect()->route('flag.index');
              
    }
}
