<?php

use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\Api\AdminDataController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\TicketController;
use App\Models\Consultation;
use App\Models\Events;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/types', [RequestTypeController::class, 'index']);

Route::get('/ticket/{id}', [TicketController::class, 'show']);

// get count of data
Route::get('/residents', [AdminDataController::class, 'residents']);
Route::get('/brgy', [AdminDataController::class, 'brgy']);
Route::get('/tickets', [AdminDataController::class, 'tickets']);
Route::get('/blotters', [AdminDataController::class, 'blotters']);

//get single data
Route::get('/resident/{id}', [AdminDataController::class, 'resident']);
Route::get('/blotter/{id}', [AdminDataController::class, 'blotter']);

//fetch zones
Route::get('/zones', [AdminDataController::class, 'zones']);

//fetch registered residents
Route::get('/leader', [AdminDataController::class, 'leader']);

Route::post('/remove/leader/{id}', [AdminUserManagementController::class, 'removeLeader'])->name('testing');

// Clinic
Route::get('/consultations', function () {
    $patients = Consultation::all()->count();

    return $patients;
});

Route::get('/consultation/ticket/{id}', function ($id) {
    $consultation = Consultation::with('patient', 'status')->find($id);
    return $consultation;
});

Route::get('/doctors', function () {
    $doctor = User::whereHas('roles', function ($query) {
        $query->where('roles.name', 'doctor');
    })->get()->count();

    return $doctor;
});

Route::get('/nurses', function () {
    $nurse = User::whereHas('roles', function ($query) {
        $query->where('roles.name', 'nurse');
    })->get()->count();

    return $nurse;
});

Route::get('/inventory/{id}', function ($id) {
    $inventory = Inventory::find($id);

    return $inventory;
});

Route::get('/events', function() {
    $events = Events::all()->count();

    return $events;
});

Route::post('/attachment', [AttachmentController::class, 'store']);
