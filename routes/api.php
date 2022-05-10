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

Route::post('login', [AuthController ::class, 'login'])->name('login');
Route::post('logout', [AuthController ::class, 'logout'])->name('logout');

Route::get('products', function(){
    return 'rr';
})->middleware(['auth.role:user,admin' ]);

Route::group(['prefix' => 'orders' , 'middleware' => 'auth.role' ], function () {
    Route::get('/',[OrderController::class , 'index']) -> name('orders');
    Route::post('store',[OrderController::class , 'store']) -> name('orders.store');
    Route::get('captain',[OrderController::class , 'captain']) -> name('orders.captain');
  });
Route::group(['prefix' => 'department' /*, 'middleware' => 'auth.role:chief,admin'*/ ], function () {
    Route::get('/{id}',[DepartmentController::class , 'department']) -> name('getDepartment');
    Route::get('/order/{id}',[DepartmentController::class , 'order_details']) -> name('getDepartment');
    Route::post('/updateStatus/{id}',[DepartmentController::class , 'order_details_update']) -> name('put.order.Department');
});




