<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketViewer;
use Illuminate\Support\Facades\URL;
use App\Jobs\SendTicketJob;

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

// Route::get('/tickets/{ticket_id}', [TicketViewer::class,'viewticket'])->name('ticket.view.single');
Route::get('/staff-login', [AuthController::class,'stafflogin'])->name('view.login');
Route::get('/staff-register', [AuthController::class,'staffregister'])->name('view.register');
Route::post('staff.login', [AuthController::class,'staffloginpost'])->name('staff.login');
//Route::post('staff.register', [AuthController::class,'staffregisterpost'])->name('staff.register');
Route::get('/tickets', [TicketViewer::class,'ticketlist'])->name('ticket.view');

Route::get('queue-api', function ()
{
    $to='akashtester15@gmail.com';
    $subject='New Support Ticket';
    $messagetext='This is a test email.';
    SendTicketJob::dispatch($to, $subject, $messagetext);
    print('Job dispatched to the queue.');
}); 
        
