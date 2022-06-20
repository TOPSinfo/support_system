<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;

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
})->name('main');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('ticket')->group(function () {
    Route::get('/list', [TicketController::class, 'listTicket'])->name('ticket.list');
    Route::get('/add', [TicketController::class, 'createTicket'])->name('ticket.add');
    Route::post('/save', [TicketController::class, 'saveTicket'])->name('ticket.save');
    Route::get('/edit/{id}', [TicketController::class, 'editTicket'])->name('ticket.edit');
    Route::post('/update', [TicketController::class, 'updateTicket'])->name('ticket.update');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.loginform');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});

Route::group(['prefix' => 'admin','middleware' => 'is_admin'], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
});

