<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/process-images', [FileController::class, 'processImages'])->name('process_images');


    Route::get('/files', [FileController::class, 'index'])->name('files.index');
Route::post('/upload', [FileController::class, 'upload']);
Route::get('/image', [FileController::class, 'displayImages'])->name('files.image');
Route::post('/export-selected-images', [FileController::class, 'exportSelectedImages'])->name('export_selected_images');
Route::get('/files/{id}', [FileController::class, 'download']);
Route::delete('/files/{id}', [FileController::class, 'delete']);

});

require __DIR__.'/auth.php';
