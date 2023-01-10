<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentrembugController;
use App\Http\Controllers\LaporanPengeluaranController;
use App\Http\Controllers\LikesrembugController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ReportrembugController;
use App\Http\Controllers\ReportVillageHeadController;
use App\Http\Controllers\RequesttopupController;
use App\Http\Controllers\TransactionController;
use App\Models\LaporanPengeluaran;
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
    Route::get('/user/topup/list', [RequesttopupController::class, 'getlisttopup']);
    Route::get('/user/topup/confirmed', [RequesttopupController::class, 'getlisttopupberhasil']);
    Route::get('/user/topup/notconfirmed', [RequesttopupController::class, 'getlisttopupbelumdikonfirm']);
    Route::post('/user/topup', [RequesttopupController::class, 'requesttopup']);
    Route::put('/user/topup/get/{id}', [RequesttopupController::class, 'konfirmtopup']);

    //user
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/user/search/{username}', [AuthController::class, 'searchuser']);
    Route::put('/user/update', [AuthController::class, 'update']);
    Route::put('/user/update/img', [AuthController::class, 'updateuserimg']);
    Route::put('/user/update/username', [AuthController::class, 'updateusername']);
    Route::put('/user/update/pin', [AuthController::class, 'updatepin']);
    Route::put('/user/update/password', [AuthController::class, 'updatepassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/user/delete', [AuthController::class, 'deleteuser']);

    //Transaksi
    Route::post('/user/transaksi/transfer', [TransactionController::class, 'newtransaksi']);
    Route::post('/user/transaksi/pembayaran', [TransactionController::class, 'pembayaran']);
    Route::post('/user/transaksi/topup', [TransactionController::class, 'topup']);
    Route::get('/user/transaksi', [TransactionController::class, 'gettransaksi']);
    Route::get('/user/transaksi/all', [TransactionController::class, 'gettransaksiall']);
    Route::get('/user/transaksi/pemasukan', [TransactionController::class, 'getpemasukan']);
    Route::get('/user/transaksi/sampah', [TransactionController::class, 'getsampah']);
    Route::get('/user/transaksi/pdam', [TransactionController::class, 'getpdam']);
    Route::get('/user/transaksi/detail/{id}', [TransactionController::class, 'getdetailtrx']);
    Route::get('/user/transaksi/{query}', [TransactionController::class, 'searchpemabayaran']);
    Route::get('/user/pemasukan/{query}', [TransactionController::class, 'searchpemasukan']);
    Route::get('/user/pemasukan/sampah/{query}', [TransactionController::class, 'searchpemasukansampah']);
    Route::get('/user/pemasukan/pdam/{query}', [TransactionController::class, 'searchpemasukanpdam']);


    //Rembug
    Route::post('/user/rembug/add', [MeetingController::class, 'newrembug']);
    Route::delete('/user/rembug/delete/{id}', [MeetingController::class, 'deleterembug']);
    Route::put('/user/rembug/update/{id}', [MeetingController::class, 'update']);
    Route::get('/user/rembug', [MeetingController::class, 'getallrembug']);
    Route::get('/user/rembug/user', [MeetingController::class, 'getrembugusers']);

    //CommentRembyg
    Route::post('/user/rembug/comment/add/{id}', [CommentrembugController::class, 'store']);
    Route::put('/user/rembug/comment/update/{id}', [CommentrembugController::class, 'update']);
    Route::get('/user/rembug/comment/{id}', [CommentrembugController::class, 'index']);
    Route::delete('/user/rembug/comment/delete/{id}', [CommentrembugController::class, 'destroy']);

    //LIKES
    Route::post('/user/rembug/{id}/likes', [LikesrembugController::class, 'likeOrUnlike']);
   
    
    //Report
    Route::post('/user/report/add', [ReportVillageHeadController::class, 'report']);;
    Route::get('/user/report/{id}', [ReportVillageHeadController::class, 'getreportuser']);
    Route::get('/user/report', [ReportVillageHeadController::class, 'getall']);

    //LaoranPengeluaran
    Route::post('/admin/laporan/add', [LaporanPengeluaranController::class, 'report']);;
    Route::get('/admin/laporan', [LaporanPengeluaranController::class, 'getall']);

    //RembugReport
    Route::post('/user/rembug/report/add', [ReportrembugController::class, 'report']);;
    Route::get('/user/rembug/report', [ReportrembugController::class, 'getall']);
    Route::delete('/admin/rembug/delete/{id}', [MeetingController::class, 'deleterembugbyadmin']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

