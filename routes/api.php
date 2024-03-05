<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangOfficeController;
use App\Http\Controllers\TransactionController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.verify');
});    

Route::prefix('user')->middleware('jwt.verify')->group(function(){
    Route::get('/all', [UserController::class, 'show']);
});

Route::prefix('barang')->middleware('jwt.verify')->group(function(){
    Route::get('/', [BarangOfficeController::class, 'show']);
});

Route::prefix('transaction')->middleware('jwt.verify')->group(function(){
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/create',[TransactionController::class, 'submit']);
    Route::put('/{id}/update', [TransactionController::class, 'update']);
});