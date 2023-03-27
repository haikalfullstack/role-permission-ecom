<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\RoleController;

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
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');

    // Permission all routes
  
    Route::get('/all/permission', [RoleController::class, 'AllPermission'])->name('all.permission');
    Route::get('/add/permission', [RoleController::class, 'AddPermission'])->name('add.permission');
    Route::post('/store/permission', [RoleController::class, 'StorePermission'])->name('store.permission');
    Route::get('/edit/permission/{id}', [RoleController::class, 'EditPermission'])->name('edit.permission');
    Route::post('/update/permission', [RoleController::class, 'UpdatePermission'])->name('update.permission');
    Route::get('/delete/permission/{id}', [RoleController::class, 'DeletePermission'])->name('delete.permission');

       
   // Roles all routes
    Route::get('/all/roles', [RoleController::class, 'AllRoles'])->name('all.roles');
    Route::get('/add/roles', [RoleController::class, 'AddRoles'])->name('add.roles');
    Route::post('/store/roles', [RoleController::class, 'StoreRoles'])->name('store.roles');
    Route::get('/edit/roles/{id}', [RoleController::class, 'EditRoles'])->name('edit.roles');
    Route::post('/update/roles', [RoleController::class, 'UpdateRoles'])->name('update.roles');
    Route::get('/delete/roles/{id}', [RoleController::class, 'DeleteRoles'])->name('delete.roles');

    // Roles in permission
    Route::get('/add/roles/permission', [RoleController::class, 'AddRolesPermission'])->name('add.roles.permission');

    Route::post('/role/permission/store', [RoleController::class, 'RolePermissionStore'])->name('role.permission.store');

    Route::get('/all/roles/permission', [RoleController::class, 'AllRolesPermission'])->name('all.roles.permission');

    Route::get('/admin/edit/roles/{id}', [RoleController::class, 'AdminRolesEdit'])->name('admin.edit.roles');
});

// Vendor Dashboard
Route::middleware(['auth', 'role:vendor'])->group(function(){
    Route::get('vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');

    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');

    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');

    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');

    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');

    Route::post('/vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
   
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login');
