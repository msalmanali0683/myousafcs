<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\Banks\BankController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\invoice\InvoiceController;
use App\Http\Controllers\labour\LabourController;
use App\Http\Controllers\logistics\LogisticsController;
use App\Http\Controllers\logistics\LogisticsrController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\user\UsersController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('optimize');
    return '<h1>Cache facade value cleared</h1>';
});

Route::get('/migrate-fresh', function () {
    $exitCode = Artisan::call('migrate:fresh');
    return '<h1>Migrate Fresh</h1>';
});

Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return '<h1>Migrate Fresh</h1>';
});


// Main Page Route
Route::get('/', [HomePage::class, 'index'])->name('pages-home');
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');


Route::get('/app/invoice/purchase', [InvoiceController::class, 'purchase'])->name('app-invoice-purchase');
Route::get('/app/invoice/sale', [InvoiceController::class, 'sale'])->name('app-invoice-sale');
Route::get('/app/invoice/preview/{id}', [InvoiceController::class, 'show'])->name('app-invoice-show');
Route::get('/app/invoice/list', [InvoiceController::class, 'list'])->name('app-invoice-list');
Route::post('/app/ecommerce/invoice/store', [InvoiceController::class, 'store'])->name('app-invoice-store');


Route::get('/app/user/list', [UsersController::class, 'index'])->name('app-user-list');


Route::get('/app/product/list', [ProductController::class, 'index'])->name('app-product-list');
Route::post('/app/product/store', [ProductController::class, 'store'])->name('app-product-store');


Route::get('/app/ecommerce/customer/all', [CustomerController::class, 'index'])->name('app-ecommerce-customer-all');
Route::get('/app/ecommerce/customer/create', [CustomerController::class, 'create'])->name('app-ecommerce-customer-create');
Route::post('/app/ecommerce/customer/create/store', [CustomerController::class, 'store'])->name('app-ecommerce-customer-create-store');
Route::get('/app/ecommerce/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('/app/ecommerce/customer/update/{id}', [CustomerController::class, 'update'])->name('app-ecommerce-customer-update');



Route::get('/app/logistics/dashboard', [LogisticsController::class, 'dashboard'])->name('app-logistics-dashboard');
Route::get('/app/logistics/create', [LogisticsController::class, 'index'])->name('app-logistics-create');
Route::post('/app/logistics/store', [LogisticsController::class, 'store'])->name('app-logistics-store');

Route::get('/app/banks/all', [BankController::class, 'index'])->name('app-banks-all');
Route::post('/app/banks/store', [BankController::class, 'store'])->name('app-banks-store');

Route::get('/app/employee/labour', [LabourController::class, 'index'])->name('app-employee-labour');
Route::post('/app/labour/store', [LabourController::class, 'store'])->name('app-labour-store');
