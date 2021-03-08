<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ReplyController;




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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group(['middleware' => 'api','prefix' => ''], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'userProfile']);    

});

Route::group(['middleware' => 'api','prefix' => 'channels'], function ($router) {
    Route::get('', [ChannelController::class, 'index']);   
});   

Route::group(['middleware' => 'api', 'prefix' => 'threads'], function ($router) {
    Route::get('', [ThreadController::class, 'index']);    
    Route::post('', [ThreadController::class, 'store']);    
    Route::get('{thread}', [ThreadController::class, 'show']);    
    Route::put('{thread}', [ThreadController::class, 'update']);    
    Route::delete('{thread}', [ThreadController::class, 'destroy']);    
    Route::get('{thread}/replies/{reply}', [ReplyController::class, 'show']);  
    Route::put('{thread}/replies/{reply}', [ReplyController::class, 'update']);      
    Route::delete('{thread}/replies/{reply}', [ReplyController::class, 'destroy']);      
    Route::post('{thread}/replies', [ReplyController::class, 'store']);    

});