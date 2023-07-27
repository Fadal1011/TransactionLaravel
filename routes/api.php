<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddlaware;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => 'auth:sanctum'],function(){
//     Route::get('user',[UserController::class,'userDetails']);
//     Route::get('logout',[UserController::class,'logout']);
// });

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/private', function () {
//         return "bonjour";
//     });
// });




Route::apiResource("/users",UserController::class)->only('store','index');
Route::post('/login',[UserController::class,"loginUser"]);



Route::apiResource("/role",RoleController::class)->only('store');
