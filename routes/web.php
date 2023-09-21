<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

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
    return view('app');
});
   
Route::get('/document', [DocumentController::class, 'index'])->name('document');
Route::post('/document/store', [DocumentController::class, 'store'])->name('document.store');
Route::post('/document/create', [DocumentController::class, 'create']);


