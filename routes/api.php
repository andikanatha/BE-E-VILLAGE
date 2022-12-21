<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\TransactionController;
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

//User
Route::post('/user/register', [AuthController::class, 'register']);

//Admin
Route::post('/admin/register', [AuthController::class, 'registeradmin']);

//All
Route::post('/login', [AuthController::class, 'login']);

Route::get('/useralldata', [AuthController::class,'getalluser']);


Route::group(['middleware' => ['auth:sanctum']], function(){
    
    //TOPUP SALDO
    Route::put('/user/topup', [AuthController::class, 'topupSaldo']);

    //user
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/update', [AuthController::class, 'update']);
    Route::put('/user/update/img', [AuthController::class, 'updateuserimg']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/user/delete', [AuthController::class, 'deleteuser']);

    //Transaksi
    Route::post('/user/transaksi/add', [TransactionController::class, 'newtransaksi']);
    Route::get('/user/transaksi/{id_user}', [TransactionController::class, 'gettransaksi']);

    //Rembug
    Route::post('/user/rembug/add', [MeetingController::class, 'newrembug']);
    Route::delete('/user/rembug/delete', [MeetingController::class, 'deleterembug']);
    Route::get('/user/rembug/{id_user}', [MeetingController::class, 'getrembug']);
    Route::get('/user/rembug', [MeetingController::class, 'getallrembug']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
