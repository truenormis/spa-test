<?php

use App\Http\Controllers\ReplyController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\ReplyController::class,'index'])->name('reply.index');
Route::post('/replies', [\App\Http\Controllers\ReplyController::class,'store'])->name('reply.store');
Route::post('/replies/{id}', [ReplyController::class, 'reply'])->name('reply.reply');

