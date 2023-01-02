<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[UserController::class,'redirectAdmin'])->middleware(['auth','verified'])->name('dashboard');
Route::get('/product/{id}',[UserController::class,'details'])->name('goto-details');
Route::post('/add/review/{id}',[UserController::class,'storeReview'])->name('store-review');
Route::get('/delete/review/{id}/{uid}',[UserController::class,'deleteReview'])->name('delete-review');
Route::get('/edit/review/{id}/{uid}',[UserController::class,'editReview'])->name('edit-review');
Route::post('/edit/review/{id}/{uid}',[UserController::class,'updateReview'])->name('update-review');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
