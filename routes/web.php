<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/', function () {
    return redirect('login');
});

Route::view('unsuccess', 'unsuccess');

Route::middleware(['auth:sanctum', 'verified'])->get('/users', [UserController::class,'index'])->name('users')->middleware('checkuser');
Route::get('fetch-user',[UserController::class, 'fetchuser']);
Route::post('users',[UserController::class, 'store']);
Route::get('edit-user/{id}',[UserController::class, 'edit']);
Route::put('update-user/{id}',[UserController::class, 'update']);
Route::delete('delete-user/{id}',[UserController::class, 'delete']);


