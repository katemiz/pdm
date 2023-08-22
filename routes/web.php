<?php

use Illuminate\Support\Facades\Route;

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


// ADMIN INTERFACE

Route::get('/admin/users', function () {
    return view('admin.users.usr-list');
});

Route::get('/admin/users/form', [UserController::class,'form']);
Route::post('/admin/users/store/{id?}', [UserController::class,'store']);
Route::get('/admin/users/view/{id}', [UserController::class,'view']);



// Route::get('/admin/roles', RolesWire::class);
// Route::get('/admin/permissions', PermissionsWire::class);


