<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CarouselController;
Route::middleware('auth')->prefix('backend')->group(function(){

    Route::resources([
        'service'    => ServiceController::class,
        'about'      =>AboutController::class,
        'service'    =>ServiceController::class,
        'carousel'   =>CarouselController::class,
        'contact'    =>ContactController::class,
     ]);}
     );
