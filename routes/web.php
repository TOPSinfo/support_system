<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin', function () {
    return view('admin');
});

Route::prefix('ticket')->group(function () {
    Route::get('/list', [App\Http\Controllers\TicketController::class, 'listTicket'])->name('ticket.list');
    Route::get('/add', [App\Http\Controllers\TicketController::class, 'createTicket'])->name('ticket.add');
    Route::post('/save', [App\Http\Controllers\TicketController::class, 'saveTicket'])->name('ticket.save');
    Route::get('/edit/{id}', [App\Http\Controllers\TicketController::class, 'editTicket'])->name('ticket.edit');
    Route::post('/update', [App\Http\Controllers\TicketController::class, 'updateTicket'])->name('ticket.update');
});

