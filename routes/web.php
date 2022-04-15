<?php

use App\Http\Controllers\AdminClinicController;
use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlotterController;
use App\Http\Controllers\ClinicStaffController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TicketController;
use App\Models\Inventory;
use App\Models\User;
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
            Route::get('/{id}', [TicketController::class, 'show'])->name('ticket.show');
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
                // Route::get('/data', [AdminDataManagementController::class, 'index'])->name('admin.data.view');
                Route::get('/blotter', [BlotterController::class, 'index'])->name('admin.blotter');
                Route::post('/blotter/store', [BlotterController::class, 'store'])->name('admin.blotter.store');

                // resident Activation and Deactivation
                Route::put('/user/approve/{id}', [AdminUserManagementController::class, 'approve'])->name('admin.user.approve');
                Route::put('/user/deactivate/{id}', [AdminUserManagementController::class, 'deactivate'])->name('admin.user.deactivate');

                Route::put('/user/leader/{id}', [AdminUserManagementController::class, 'createLeader'])->name('admin.leader.create');
                Route::get('/remove/leader/{id}', function ($id) {
                    $leader = User::find($id);

                    dd($leader);

                    $leader->detachRole('leader');
                    $leader->attachRole('resident');

                    return redirect()->back()->with('success', 'Leader successfully added');
                })->name('admin.leader.remove');

                Route::get('/remove/test/{id}', function ($id) {
                    $leader = User::find($id);

                    dd($leader);
                });

                Route::put('/user/official/{id}', [AdminUserManagementController::class, 'createOfficial'])->name('admin.official.create');
                Route::put('/user/remove/official/{id}', [AdminUserManagementController::class, 'removeOfficial'])->name('admin.official.remove');



                //events
                Route::get('/events', [EventsController::class, 'index'])->name('events.index');
            });
        });

        Route::middleware(['role:admin|clinic|staff'])->group(function() {
            //clinic routes
            Route::group(['prefix' => 'clinic'], function () {
                Route::get('/consultations', [ConsultationController::class, 'index'])->name('clinic.index');
                Route::get('/doctors', [ClinicStaffController::class, 'doctors'])->name('clinic.doctor');
                Route::get('/nurses', [ClinicStaffController::class, 'nurses'])->name('clinic.nurse');

                Route::post('/consultations', [ConsultationController::class, 'store'])->name('clinic.consultation.store');

                Route::put('/doctor/create/{id}', [ClinicStaffController::class, 'createDoctor'])->name('clinic.create.doctor');
                Route::put('/nurse/create/{id}', [ClinicStaffController::class, 'createNurse'])->name('clinic.create.nurse');

                Route::group(['prefix' => 'inventory'], function () {
                    Route::get('/', [InventoryController::class, 'index'])->name('clinic.inventory');
                    Route::post('/', [InventoryController::class, 'store'])->name('inventory.store');
                });
            });
        });
});
