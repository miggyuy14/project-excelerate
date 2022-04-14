<?php

use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlotterController;
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
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::get('/register', [PagesController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'create']);
Route::get('/logout', [PagesController::class, 'logout'])->name('logout');
Route::get('/', [PagesController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {
        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/', [TicketController::class, 'index'])->name('ticket.index');
            Route::get('/{id}', [TicketController::class, 'show'])->name('ticket.store');
            Route::get('/create', [TicketController::class, 'create'])->name('ticket.create');
            Route::post('/store', [TicketController::class, 'store'])->name('ticket.store');
            Route::put('/{id}/approve', [TicketController::class, 'approve']);
            Route::put('/{id}/disapprove', [TicketController::class, 'disapprove']);
        });

        Route::middleware(['role:admin|zone_leader|staff'])->group(function() {
            //admin routes
            Route::group(['prefix' => 'admin'], function () {
                Route::get('/users', [AdminUserManagementController::class, 'residents'])->name('admin.users.view');
                Route::get('/users/access', [AdminUserManagementController::class, 'access'])->name('admin.users.pending.view');
                Route::get('/officials', [AdminUserManagementController::class, 'officials'])->name('admin.officials.view');
                Route::get('/leaders', [AdminUserManagementController::class, 'leaders'])->name('admin.leaders.view');
                Route::get('/data', [AdminDataManagementController::class, 'index'])->name('admin.data.view');
                Route::get('/blotter', [BlotterController::class, 'index'])->name('admin.blotter');
                Route::post('/blotter/store', [BlotterController::class, 'store'])->name('admin.blotter.store');
            });
        });
});
