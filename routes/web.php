<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use App\Livewire\Cr;
use App\Livewire\Ecn;
use App\Livewire\LwDocument;
use App\Livewire\LwDocumentor;
use App\Livewire\Material;
use App\Livewire\Process;
use App\Livewire\EndProduct;
use App\Livewire\Product;
use App\Livewire\ProductNote;
use App\Livewire\Engineering;


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


Route::get('/engineering/{action}', Engineering::class);



require __DIR__.'/auth.php';

/*
ADMIN
INTERFACE
*/

Route::middleware(['auth'])->group(function () {

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

    // COMPANIES
    Route::get('/admin/companies', function () {
        return view('admin.companies.company-list');
    });

    Route::get('/admin/companies/form/{id?}', [CompanyController::class,'form']);
    Route::post('/admin/companies/store/{id?}', [CompanyController::class,'store']);
    Route::get('/admin/companies/view/{id}', [CompanyController::class,'view']);
    Route::get('/admin/companies/delete/{id}', [CompanyController::class, 'delete']);

    // PROJECTS
    Route::get('/admin/projects', function () {
        return view('admin.projects.project-list');
    });

    Route::get('/admin/projects/form/{id?}', [ProjectController::class,'form']);
    Route::post('/admin/projects/store/{id?}', [ProjectController::class,'store']);
    Route::get('/admin/projects/view/{id}', [ProjectController::class,'view']);
    Route::get('/admin/projects/delete/{id}', [ProjectController::class, 'delete']);
});





/*
PDM FUNCTIONS
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/cr/{action}/{id?}', Cr::class);
    Route::get('/ecn/{action}/{id?}', Ecn::class);

    // END PRODUCTS
    Route::get('/endproducts/{action}/{id?}', EndProduct::class);

    // PRODUCTS
    Route::get('/products/{action}/{id?}', Product::class);


    // DOCUMENTS
    Route::get('/documents/{action}/{id?}', LwDocument::class);
    Route::get('/documentor/{action}/{id?}', LwDocumentor::class);



    // MATERIAL, PROCESS and NOTES
    Route::get('/material/{action}/{id?}', Material::class);
    Route::get('/process/{action}/{id?}', Process::class);
    Route::get('/notes/{action}/{id?}', ProductNote::class);





});
