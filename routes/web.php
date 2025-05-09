<?php

use App\Http\Controllers\PublicTicketController;
use App\Livewire\AcceptInvitation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuotePdfController;

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

Route::get('/', function () {
    return redirect('/admin');
});

Route::middleware('signed')
    ->get('invitation/{invitation}/accept', AcceptInvitation::class)
    ->name('invitation.accept');

Route::middleware('signed')
    ->get('quotes/{quote}/pdf', QuotePdfController::class)
    ->name('quotes.pdf');

Route::get('/ticket/create', [PublicTicketController::class, 'create']);
Route::post('/ticket', [PublicTicketController::class, 'store']);
Route::get('/ticket/view/{token}', [PublicTicketController::class, 'view'])->name('tickets.view');
