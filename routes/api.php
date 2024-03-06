<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangOfficeController;
use App\Http\Controllers\BarangCenterController;
use App\Http\Controllers\BarangController;
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
    Route::get('/', [UserController::class, 'show']);
});

Route::prefix('office')->middleware('jwt.verify')->group(function(){
    Route::get('/', [BarangOfficeController::class, 'show']);
    Route::get('/detail/{id}', [BarangOfficeController::class, 'detailBarang']);
    Route::delete('/{id}', [BarangOfficeController::class, 'delete']);
    Route::post('/transaction/create',[TransactionController::class, 'submit']);
    Route::get('/transaction/all',[TransactionController::class, 'showById']);
});

Route::prefix('center')->middleware('jwt.verify')->group(function(){
    // CRUD Barang    
    Route::get('/barang', [BarangCenterController::class, 'index']);
    Route::get('/barang/{id}', [BarangCenterController::class, 'show']);
    Route::post('/barang', [BarangCenterController::class, 'store']);
    Route::put('/barang/{id}', [BarangCenterController::class, 'update']);
    Route::delete('/barang/{id}', [BarangCenterController::class, 'destroy']);

    // CRUD Cabang
    Route::get('/barang/cabang/{cabangId}', [BarangCenterController::class, 'showBarangByCabang']);
    
    Route::get('/cabang', [BarangCenterController::class, 'indexCabang']);
    Route::post('/cabang', [BarangCenterController::class, 'storeCabang']);
    Route::put('/cabang/{id}', [BarangCenterController::class, 'updateCabang']);
    Route::delete('/cabang/{id}', [BarangCenterController::class, 'destroyCabang']);

    Route::get('/transaction/all', [TransactionController::class, 'index']);
    Route::put('/{id}/update', [TransactionController::class, 'update']);
});

Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index']); // Mendapatkan semua barang
    Route::get('/{id}', [BarangController::class, 'show']); // Mendapatkan detail barang berdasarkan ID
    Route::post('/', [BarangController::class, 'store']); // Membuat barang baru
    Route::put('/{id}', [BarangController::class, 'update']); // Memperbarui barang berdasarkan ID
    Route::delete('/{id}', [BarangController::class, 'destroy']); // Menghapus barang berdasarkan ID
});


