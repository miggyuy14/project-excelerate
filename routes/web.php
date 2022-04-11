<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
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
Route::get('/login', [PagesController::class, 'login'])->name('login');
Route::get('/register', [PagesController::class, 'register'])->name('register');
Route::get('/logout', [PagesController::class, 'logout'])->name('logout');

Route::get('/', [PagesController::class, 'welcome'])->name('welcome');

Auth::routes();

Route::middleware(['auth'])->group(function () {
        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/', [TicketController::class, 'index'])->name('ticket.index');
            Route::get('/{id}', [TicketController::class, 'show'])->name('ticket.store');
            Route::get('/create', [TicketController::class, 'create'])->name('ticket.create');
            Route::post('/store', [TicketController::class, 'store'])->name('ticket.store');
            Route::put('/{id}/approve', [TicketController::class, 'approve']);
            Route::put('/{id}/disapprove', [TicketController::class, 'disapprove']);
        });
});
