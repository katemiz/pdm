<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\UsersWire;

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

Route::get('/admin/users', UsersWire::class);
// Route::get('/admin/roles', RolesWire::class);
// Route::get('/admin/permissions', PermissionsWire::class);


