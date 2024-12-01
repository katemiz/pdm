<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CkImgController;





use App\Livewire\Welcome;


use App\Livewire\Cr;
use App\Livewire\Ecn;
use App\Livewire\LwPermission;
use App\Livewire\LwProject;
// use App\Livewire\LwRole;
use App\Livewire\LwUser;

use App\Livewire\ChangePassword;
// use App\Livewire\Material;
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
use App\Livewire\Geometry;


use App\Livewire\LwCompany;






use App\Livewire\Documents;
use App\Livewire\DocumentShow;
use App\Livewire\DocumentCreateUpdate;

use App\Livewire\Materials;
use App\Livewire\MaterialShow;
use App\Livewire\MaterialCreateUpdate;

use App\Livewire\Roles;
use App\Livewire\RoleShow;
use App\Livewire\RoleCreateUpdate;

use App\Livewire\Users;
use App\Livewire\UserShow;
use App\Livewire\UserCreateUpdate;


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


Route::get('/', Welcome::class);



require __DIR__.'/auth.php';

/*
ADMIN
INTERFACE
*/

Route::middleware(['auth'])->group(function () {


    // USERS
    // *****************************************************************************
    Route::get('/usrs', Users::class);
    Route::get('/usrs/create', UserCreateUpdate::class);
    Route::post('/usrs', UserCreateUpdate::class);
    Route::get('/usrs/{id}', UserShow::class);
    Route::get('/usrs/{id}/edit', UserCreateUpdate::class);
    Route::patch('/usrs/{id}', UserCreateUpdate::class);
    Route::delete('/usrs/{id}', UserCreateUpdate::class);





                        // CHANGE PASSWORDS
                        Route::get('/admin-users/{action}/{id?}', LwUser::class);
                        Route::get('/profile', ChangePassword::class);




    // ROLES
    // *****************************************************************************
    Route::get('/roles', Roles::class);
    Route::get('/roles/create', RoleCreateUpdate::class);
    Route::post('/roles', RoleCreateUpdate::class);
    Route::get('/roles/{id}', RoleShow::class);
    Route::get('/roles/{id}/edit', RoleCreateUpdate::class);
    Route::patch('/roles/{id}', RoleCreateUpdate::class);
    Route::delete('/roles/{id}', RoleCreateUpdate::class);


    // DOCUMENTS
    // *****************************************************************************
    Route::get('/docs', Documents::class);
    Route::get('/docs/create', DocumentCreateUpdate::class);
    Route::post('/docs', DocumentCreateUpdate::class);
    Route::get('/docs/{id}', DocumentShow::class);
    Route::get('/docs/{id}/edit', DocumentCreateUpdate::class);
    Route::patch('/docs/{id}', DocumentCreateUpdate::class);
    Route::delete('/docs/{id}', DocumentCreateUpdate::class);




    // MATERIALS
    // *****************************************************************************
    Route::get('/materials', Materials::class);
    Route::get('/materials/create', MaterialCreateUpdate::class);
    Route::post('/materials', MaterialCreateUpdate::class);
    Route::get('/materials/{id}', MaterialShow::class);
    Route::get('/materials/{id}/edit', MaterialCreateUpdate::class);
    Route::patch('/materials/{id}', MaterialCreateUpdate::class);
    Route::delete('/materials/{id}', MaterialCreateUpdate::class);





    // CK IMG UPLOAD
    Route::post('/ckimages', [CkImgController::class, 'store'])->name('ckimages');

    // // ROLES
    // Route::get('/admin-roles/{action}/{id?}', LwRole::class);

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



















    // MOMs
    Route::get('/moms/{action}/{id?}', LwMom::class);


    // STANDARD FAMILIES
    Route::get('/std-family/{action}/{id?}', LwStandardFamily::class);


    // MATERIAL, PROCESS and NOTES
    //Route::get('/material/{action}/{id?}', Material::class);
    Route::get('/process/{action}/{id?}', Process::class);
    Route::get('/notes/{action}/{id?}', ProductNote::class);


    // PDF GENERATION
    Route::get('/pdf/bom/{id}', [PDFController::class, 'getType']);
    Route::get('/pdf/cascadedbom/{id}', [PDFController::class, 'generateCascadedPdf']);


    // ENGINEERING
    Route::get('/engineering/{action}', Engineering::class);
    Route::get('/engineering/geometry/{shape}', Geometry::class);

    // DENEME AMACLI
    Route::get('/viewme', LwProduct2::class);


});
