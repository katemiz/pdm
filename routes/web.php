<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CkImgController;

use App\Livewire\Cr;
use App\Livewire\Ecn;
use App\Livewire\LwDocument;
use App\Livewire\LwPermission;
use App\Livewire\LwProject;
use App\Livewire\LwRole;
use App\Livewire\LwUser;

use App\Livewire\ChangePassword;
use App\Livewire\Material;
use App\Livewire\Process;
use App\Livewire\LwItem;
use App\Livewire\LwAssy;
use App\Livewire\LwBuyable;
use App\Livewire\LwDetail;
use App\Livewire\LwHtmlDocument;
use App\Livewire\LwSellable;
use App\Livewire\LwStandardFamily;
use App\Livewire\LwMom;
use App\Livewire\LwProduct;
use App\Livewire\LwProduct2;
use App\Livewire\ProductNote;
use App\Livewire\Engineering;
use App\Livewire\EngMast;
use App\Livewire\Geometry;

use App\Livewire\MatFamilyManager;


use App\Livewire\LwCompany;

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

Route::middleware(['auth'])->group(function () {

    // USERS
    Route::get('/admin-users/{action}/{id?}', LwUser::class);
    Route::get('/profile', ChangePassword::class);

    // CK IMG UPLOAD
    Route::post('/ckimages', [CkImgController::class, 'store'])->name('ckimages');

    // ROLES
    Route::get('/admin-roles/{action}/{id?}', LwRole::class);

    // PERMISSIONS
    Route::get('/admin-permissions/{action}/{id?}', LwPermission::class);

    // COMPANIES
    Route::get('/admin-companies/{action}/{id?}', LwCompany::class);

    // PROJECTS
    Route::get('/admin-projects/{action}/{id?}', LwProject::class);

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

    // SELLABLES
    Route::get('/endproducts/{action}/{id?}', LwSellable::class);

    // PRODUCTS
    Route::get('/products/{action}/{id?}', LwProduct::class);
    Route::get('/parts/{action}/{id?}', LwItem::class);         // List All Items

    //Route::get('/details/{action}/{id?}', LwDetail::class);     // Detail Parts

    Route::get('/details/{part_type}/{action}/{id?}', LwDetail::class);     // Detail-MakeFrom-Standard Parts


    Route::get('/products-assy/{action}/{id?}', LwAssy::class); // Assy Parts
    Route::get('/buyables/{action}/{id?}', LwBuyable::class);   // Buyable Parts


    // DOCUMENTS
    Route::get('/documents/{action}/{id?}', LwDocument::class);
    Route::get('/documents-html/{action}/{id?}', LwHtmlDocument::class);


    // MOMs
    Route::get('/moms/{action}/{id?}', LwMom::class);


    // STANDARD FAMILIES
    Route::get('/std-family/{action}/{id?}', LwStandardFamily::class);


    // MATERIAL, PROCESS and NOTES
    Route::get('/material/{action}/{id?}', Material::class);
    Route::get('/process/{action}/{id?}', Process::class);
    Route::get('/notes/{action}/{id?}', ProductNote::class);


    Route::get('/material2/{action}/{id?}', MatFamilyManager::class);


    // PDF GENERATION
    Route::get('/pdf/bom/{id}', [PDFController::class, 'getType']);
    Route::get('/pdf/cascadedbom/{id}', [PDFController::class, 'generateCascadedPdf']);


    // ENGINEERING
    Route::get('/engineering/{action}', Engineering::class);
    Route::get('/engineering/geometry/{shape}', Geometry::class);


    Route::get('/engineering/mast/{action}', EngMast::class);


    // DENEME AMACLI
    Route::get('/viewme', LwProduct2::class);


});
