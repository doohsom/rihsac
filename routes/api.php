<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Profile\GuarantorController;
use App\Http\Controllers\Api\Profile\ResidentialController;
use App\Http\Controllers\Api\Profile\EmploymentController;
use App\Http\Controllers\Api\Profile\BankController;

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
Route::post('/login', [AuthController::class, 'login'])->name('user.login') ;
Route::post('/register', [RegisterController::class, 'register'])->name('user.register');

Route::middleware(['jwt.user'])->group(function(){
    Route::post('/email/verify', [ProfileController::class, 'verifyEmailAddress'])->name('user.email.verify');
    Route::post('/email/resend', [ProfileController::class, 'resendEmailWithCode'])->name('user.email.resend');
    Route::post('/phone/update', [ProfileController::class, 'storePhoneNumber'])->name('user.phone.update');
    Route::post('/phone/verify', [ProfileController::class, 'verifyPhoneNumber'])->name('user.phone.verify');
    Route::post('/phone/resend', [ProfileController::class, 'resendSMSWithCode'])->name('user.phone.resend');
    Route::post('/transaction-pin', [ProfileController::class, 'createTransactionPIN'])->name('user.transaction.pin-create');
    Route::post('/username/update', [ProfileController::class, 'createUsername'])->name('user.username.update');

    Route::prefix('profile')->group(function() {
        Route::post('/guarantor', [GuarantorController::class, 'store'])->name('user.post.guarantor');
        Route::get('/guarantor', [GuarantorController::class, 'read'])->name('user.get.guarantor');
        Route::post('/residential', [ResidentialController::class, 'store'])->name('user.post.residential');
        Route::get('/residential', [ResidentialController::class, 'read'])->name('user.get.residential');
        Route::post('/employment', [EmploymentController::class, 'store'])->name('user.post.employment');
        Route::get('/employment', [EmploymentController::class, 'read'])->name('user.get.employment');
        Route::post('/banking', [BankController::class, 'store'])->name('user.post.banking');
        Route::get('/banking', [BankController::class, 'read'])->name('user.get.banking');
    });

});
Route::prefix('profile')->group(function(){

});

