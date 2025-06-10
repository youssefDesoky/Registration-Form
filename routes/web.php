<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\WhatsAppValidationController;
use App\Http\Controllers\ValidationController;

Route::get('/', function () {
    return view('index');
});

Route::get('/register', function () {
    return view('regForm');
});

Route::get('/language/{locale}', [App\Http\Controllers\LanguageController::class, 'switchLanguage'])->name('language.switch');

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

Route::post('/check-whatsapp', [WhatsAppValidationController::class, 'check']);


Route::post('/validate/username', [ValidationController::class, 'checkUsername']);
Route::post('/validate/phone', [ValidationController::class, 'checkPhone']);
Route::post('/validate/email', [ValidationController::class, 'checkEmail']);
Route::post('/validate/whatsapp', [ValidationController::class, 'checkWhatsApp']);