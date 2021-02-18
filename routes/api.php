<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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


Route::group(['prefix' => 'v1', 'namespace'=>'App\Http\Controllers'],function ()
{

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('forget_password', 'AuthController@forgetPassword' );
    Route::post('change_password', 'AuthController@changePassword' );



    Route::middleware('auth:api')->group( function() {

        Route::post('profils', 'AuthController@profile');
        Route::get('scan_qrcode', 'MainController@scanQrCode');
        Route::post('send_request', 'MainController@sendRequest');
        Route::get('user_requests', 'MainController@userRequests');
        Route::post('active_user_request', 'MainController@activeUserRequest');
        Route::get('other_requests', 'MainController@otherRequests');

    });

});
