<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\FlagController;
use App\Http\Controllers\FolderController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');



Route::middleware('auth')->prefix('backend')->group(function() {

    Route::resources([

        'department' => DepartmentController::class,
        'user' => UserController::class,
        'designation' => DesignationController::class,
        'office' => OfficeController::class,
        'flag' => FlagController::class,
        'folder' => FolderController::class,
        'dispatch' => DispatchController::class,


    ]);
//    department
    Route::get('/department/delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');
    //user//
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    //designation//
    Route::get('/designation/delete/{id}', [DesignationController::class, 'delete'])->name('designation.delete');
    //office//
    Route::get('/office/delete/{id}', [OfficeController::class, 'delete'])->name('office.delete');
    //flag//
    Route::get('/flag/delete/{id}', [FlagController::class, 'delete'])->name('flag.delete');
    //folder//
    Route::get('/folder/delete/{id}', [FolderController::class, 'delete'])->name('folder.delete');
    //dispatch//
    Route::get('/dispatch/delete/{id}', [DispatchController::class, 'delete'])->name('dispatch.delete');

   Route::get('/dispatches/assigned_to_me/tasks', [DispatchController::class, 'assigned'])->name('dispatches.assigned_to_me');
   Route::get('/dispatches/approved', [DispatchController::class, 'approved'])->name('dispatches.approved');
    Route::get('/dispatches/rejected', [DispatchController::class, 'rejected'])->name('dispatches.rejected');
    Route::get('/dispatches/returned', [DispatchController::class, 'returned'])->name('dispatches.returned');
    Route::get('/dispatches/recommended', [DispatchController::class, 'recommended'])->name('dispatches.recommended');
    Route::post('/dispatches/update-status/{id}', [DispatchController::class, 'updateStatus'])->name('dispatch.updateStatus');


});
    Auth::routes();

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

//scopes
//    Route::get('/get/dispatch/pending', [App\Http\Controllers\DispatchController::class, 'pendingDispatch'])->name('get.dispatch.pending');


