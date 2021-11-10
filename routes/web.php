<?php

use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ClientController;
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

Route::view('/','login')
    ->middleware('guest')
    ->name('login');

Route::view('/register','register')
    ->middleware('guest')
    ->name('register');

Route::post('/register',[AuthenticationController::class,'register'])
    ->middleware('guest');
 
Route::post('/',[AuthenticationController::class,'login'])
    ->middleware('guest');

Route::middleware('auth')->group(function() {
    Route::get('logout',[AuthenticationController::class,'logout'])
        ->middleware('query.token')
        ->name('logout');

    Route::get('auth-token',[AuthenticationController::class,'token'])
        ->name('auth.token');

    Route::middleware('role:admin,staff')->prefix('staff')->group(function() {
        Route::get('/',[AdminStaffController::class,'medicines'])
            ->name('staff.home');

        Route::get('/medicine/delete/{id}',[AdminStaffController::class,'medicineDelete'])
            ->middleware('query.token')
            ->name('staff.medicine.delete');

        Route::post('/medicine/edit',[AdminStaffController::class,'medicineEdit'])
            ->name('staff.medicine.edit');

        Route::get('/medicine/show/{id?}',[AdminStaffController::class,'medicineShow'])
            ->middleware('query.token')
            ->name('staff.medicine.show');

        Route::post('/medicine/add',[AdminStaffController::class,'medicineAdd'])
            ->name('staff.medicine.add');

        
        Route::get('/appointments',[AdminStaffController::class,'appointments'])
            ->name('staff.appointment');

        Route::post('/appointments/action',[AdminStaffController::class,'rejectOrApprove'])
            ->name('staff.appointment.action');

        Route::get('/reminders',[AdminStaffController::class,'reminders'])
            ->name('staff.reminders');

        Route::post('/reminders/send',[AdminStaffController::class,'sendReminder'])
            ->name('staff.reminders.send');
    });

    Route::middleware('role:client')->prefix('client')->group(function() {
        Route::get('/',[ClientController::class,'medicines'])->name('client.home');
        Route::post('/appoint-now',[ClientController::class,'appoint'])->name('client.appoint');
        Route::get('/appointments',[ClientController::class,'appointments'])->name('client.appointment');
        Route::get('/appointments/cancel',[ClientController::class,'cancelAppointments'])->name('client.appointment.cancel');
    });
});