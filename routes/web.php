<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ImageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ArticleController::class, 'index'])->name('articles.all');
Route::get('/images', [ImageController::class, 'index'])->name('images.all');
Route::get('/images/own', [ImageController::class, 'ownindex'])->name('images.own');

Route::get('articles/own', [ArticleController::class, 'ownindex'])->middleware('auth')->name('articles.own');
Route::resource('articles', ArticleController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->controller(ImageController::class)->group(function(){
    Route::get('/images/upload', 'upload')->name('images.upload');    
    Route::post('/images/upload', 'store')->name('images.store');
});

require __DIR__.'/auth.php';
