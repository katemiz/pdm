<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});





require __DIR__.'/auth.php';


/*
ADMIN
INTERFACE
*/

// USERS
Route::get('/admin/users', function () {
    return view('admin.users.usr-list');
});

Route::get('/admin/users/form/{id?}', [UserController::class,'form']);
Route::post('/admin/users/store/{id?}', [UserController::class,'store']);
Route::get('/admin/users/view/{id}', [UserController::class,'view']);
Route::get('/admin/users/delete/{id}', [UserController::class, 'delete']);

// ROLES
Route::get('/admin/roles', function () {
    return view('admin.roles.role-list');
});

Route::get('/admin/roles/form/{id?}', [RoleController::class,'form']);
Route::post('/admin/roles/store/{id?}', [RoleController::class,'store']);
Route::get('/admin/roles/view/{id}', [RoleController::class,'view']);
Route::get('/admin/roles/delete/{id}', [RoleController::class, 'delete']);

// PERMISSIONS
Route::get('/admin/permissions', function () {
    return view('admin.permissions.permission-list');
});

Route::get('/admin/permissions/form/{id?}', [PermissionController::class,'form']);
Route::post('/admin/permissions/store/{id?}', [PermissionController::class,'store']);
Route::get('/admin/permissions/view/{id}', [PermissionController::class,'view']);
Route::get('/admin/permissions/delete/{id}', [PermissionController::class, 'delete']);




