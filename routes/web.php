<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanDetailController;
use App\Http\Controllers\EmiProcessingController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('loan-details',[LoanDetailController::class,'index'])->name('loan-details.index');
Route::get('emi-processing',[EmiProcessingController::class,'index'])->name('emi-processing.index');
Route::get('emi-processing/process-data', [EmiProcessingController::class, 'processData'])->name('emi-processing.process-data');
