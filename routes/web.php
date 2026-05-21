<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

#region [LOGIN PAGE]
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
#endregion
