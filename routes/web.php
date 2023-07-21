<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NetworkController;
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
Route::get('/',[NetworkController::class,'index'])->name('network.index');
Route::post('/network/store',[NetworkController::class,'store'])->name('network.store'); 
Route::get('network/display',[NetworkController::class,'display'])->name('network.display'); 
Route::get('delete-data/{id}',[NetworkController::class,'delete'])->name('network.delete');
Route::get('/contacts',[ContactController::class,'index']);
Route::post('/contact/store',[ContactController::class,'store'])->name('contact.store');
Route::get('/contact/delete',[ContactController::class,'delete'])->name('contact.delete');
Route::post('/contact/display',[ContactController::class,'update'])->name('contact.display');
 