<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

Route::get('/', function () {
    return view('index');
});

Route::get('/register', function () {
    return view('regForm');
});

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
