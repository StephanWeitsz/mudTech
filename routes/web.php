<?php
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

use App\Http\Controllers\ImageUploadController;
Route::get('/image-upload', [ImageUploadController::class, 'showForm']);
Route::post('/image-upload', [ImageUploadController::class, 'upload'])->name('image.upload');



/*
Route::get('/', function () {

    //dd(env('APP_NAME'));

    $meetings = [];
    return view('ezimeeting::home', compact($meetings));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $meetings = [];
        return view('ezimeeting::home', compact($meetings));
    })->name('dashboard');
});
*/
