<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DepartmentController;



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

// 2- 	A secure login to application using API login 
Route::post('login', [AuthController ::class, 'login'])->name('login');
Route::post('logout', [AuthController ::class, 'logout'])->name('logout');

// 3-	A route with secure login based on secure login 
Route::group(['prefix' => 'orders'  , 'middleware' => 'auth.role'], function () {

    // a- A route with secure login based on secure login you choose to implement:
    Route::post('store',[OrderController::class , 'store']) -> name('orders.store');

    // c- API for captain to show order and order detail including calculated fields.
    Route::get('/{id}',[OrderController::class , 'order_details']) -> name('orders.captain');
  });

//   b- API based on role for each chief (admin has power) for:
    // Each department will get his own items to prepar    // 
Route::group(['prefix' => 'department' , 'middleware' => 'auth.role:chief,admin' ], function () {
    Route::get('/{id}',[DepartmentController::class , 'department']) -> name('getDepartment');
    Route::post('/updateStatus/{id}',[DepartmentController::class , 'order_details_update']) -> name('put.order.Department');
});




