<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'] );

Route::post('/create', [\App\Http\Controllers\HomeController::class, 'create'] );
Route::get('/login', [\App\Http\Controllers\HomeController::class, 'login'])->name('login');
Route::post('/login/check', [\App\Http\Controllers\HomeController::class, 'check']);

Route::get('/qr/show', [\App\Http\Controllers\HomeController::class, 'qr'] )->middleware(['auth:users']);
Route::post('/qr/public', [\App\Http\Controllers\HomeController::class, 'update'] )->middleware(['auth:users']);
Route::post('/qr/update/{id}', [\App\Http\Controllers\HomeController::class, 'updateId'] )->middleware(['auth:users']);
Route::get('/qr/my-requests', [\App\Http\Controllers\HomeController::class, 'my'] )->middleware(['auth:users']);
Route::get('/qr/others-requests', [\App\Http\Controllers\HomeController::class, 'other'] )->middleware(['auth:users']);
Route::post('/qr/send', [\App\Http\Controllers\HomeController::class, 'send'] )->middleware(['auth:users']);
Route::get('/qr/{uuid}', [\App\Http\Controllers\HomeController::class, 'uuid'] )->middleware(['auth:users']);
Route::get('/logout', [\App\Http\Controllers\HomeController::class, 'logout'] )->middleware(['auth:users']);

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('users')->name('users/')->group(static function() {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::post('/',                                            'UsersController@store')->name('store');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}',                                      'UsersController@update')->name('update');
            Route::delete('/{user}',                                    'UsersController@destroy')->name('destroy');
            Route::get('/export',                                       'UsersController@export')->name('export');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('requests')->name('requests/')->group(static function() {
            Route::get('/',                                             'RequestsController@index')->name('index');
            Route::get('/create',                                       'RequestsController@create')->name('create');
            Route::post('/',                                            'RequestsController@store')->name('store');
            Route::get('/{request}/edit',                               'RequestsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RequestsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{request}',                                   'RequestsController@update')->name('update');
            Route::delete('/{request}',                                 'RequestsController@destroy')->name('destroy');
            Route::get('/export',                                       'RequestsController@export')->name('export');
        });
    });
});
