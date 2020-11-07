<?php

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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::resource('kategori', 'CategoryController')->except([
        'create', 'show'
    ]);

    Route::resource('produk', 'ProductController');
    Route::resource('role', 'RoleController')->except([
        'create', 'show', 'edit', 'update'
    ]);
    Route::resource('users', 'UserController')->except([
        'show'
    ]);
    Route::get('/users/roles/{id}', 'UserController@roles')->name('users.roles');
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::post('/users/permission', 'UserController@addPermission')->name('users.add_permission');
    Route::get('/users/role-permission', 'UserController@rolePermission')->name('users.roles_permission');
    Route::put('/users/permission/{role}', 'UserController@setRolePermission')->name('users.setRolePermission');
});

