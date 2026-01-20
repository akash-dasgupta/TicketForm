<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\URL;

URL::forceScheme('https');

$RecipientEmail =['akashtester15@gmail.com'];
Mail::to($RecipientEmail);

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/support', [TicketController::class,'supportform'])->name('supportform');
Route::post('form-data', [TicketController::class,'getFormData'])->name('form.data');
Route::get('send-email',[TicketController::class,'sendEmail'])->name('send.email');

Route::get('/support/thanks', [TicketController::class,'thanks'])->name('thanks');
        
