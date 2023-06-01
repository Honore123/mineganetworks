<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\PricingBookController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationProductController;
use App\Http\Controllers\RiggerController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UploadFrameworkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Models\Rigger;
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

Route::get('/', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('quotation')->middleware(['auth'])->group(function () {
    Route::get('', [QuotationController::class, 'index'])->name('quotation.index');
    Route::get('new_quotation', [QuotationController::class, 'add'])->name('quotation.add');
    Route::get('{quotation}', [QuotationController::class, 'items'])->name('quotation.items');
    Route::get('edit/{quotation}', [QuotationController::class, 'edit'])->name('quotation.edit');
    Route::get('download/{quotation}', [QuotationController::class, 'downloadQuotation'])->name('quotation.download');
    Route::post('', [QuotationController::class, 'store'])->name('quotation.store');
    Route::post('products/{quotation}', [QuotationProductController::class, 'store'])->name('quotation-product.store');
    Route::put('{quotation}', [QuotationController::class, 'update'])->name('quotation.update');
    Route::get('products/source/{client_id}', [QuotationProductController::class, 'source'])->name('quotation-source');
    Route::put('products/{quotation}', [QuotationProductController::class, 'update'])->name('quotation-product.update');
    Route::delete('products/{quotation}', [QuotationProductController::class, 'delete'])->name('quotation-product.delete');
    Route::delete('{quotation}', [QuotationController::class, 'delete'])->name('quotation.delete');
});

Route::prefix('purchase-order')->middleware(['auth'])->group(function () {
    Route::get('', [PurchaseOrderController::class, 'index'])->name('purchase-order.index');
    Route::get('new_po', [PurchaseOrderController::class, 'add'])->name('purchase-order.add');
    Route::get('{order}', [PurchaseOrderController::class, 'items'])->name('purchase-order.items');
    Route::get('download/{order}', [PurchaseOrderController::class, 'download'])->name('purchase-order.download');
    Route::post('', [PurchaseOrderController::class, 'store'])->name('purchase-order.store');
    Route::post('products/{order}', [PurchaseProductController::class, 'store'])->name('purchase-order-product.store');
    Route::put('products/{order}', [PurchaseProductController::class, 'update'])->name('purchase-order-product.update');
    Route::delete('products/{order}', [PurchaseProductController::class, 'delete'])->name('purchase-order-product.delete');
    Route::delete('{order}', [PurchaseOrderController::class, 'delete'])->name('purchase-order.delete');
});
Route::prefix('invoice')->middleware(['auth'])->group(function () {
    Route::get('', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('new_invoice', [InvoiceController::class, 'create'])->name('invoice.add');
    Route::get('{invoice}', [InvoiceItemController::class, 'index'])->name('invoiceItem.index');
    Route::get('download/{invoice}', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::post('', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::post('{invoice}', [InvoiceItemController::class, 'store'])->name('invoiceItem.store');
    Route::put('{item}', [InvoiceItemController::class, 'update'])->name('invoiceItem.update');
    Route::delete('{invoice}', [InvoiceController::class, 'destroy'])->name('invoice.delete');
    Route::delete('items/{item}', [InvoiceItemController::class, 'destroy'])->name('invoiceItem.delete');
});
Route::prefix('products')->middleware(['auth'])->group(function () {
    Route::get('', [ProductsController::class, 'index'])->name('product.index');
    Route::get('{product}', [ProductsController::class, 'edit'])->name('product.edit');
    Route::post('', [ProductsController::class, 'store'])->name('product.store');
    Route::post('upload', [ProductsController::class, 'upload'])->name('product.upload');
    Route::put('{product}', [ProductsController::class, 'update'])->name('product.update');
    Route::delete('{product}', [ProductsController::class, 'delete'])->name('product.delete');
});

Route::prefix('customers')->group(function () {
    Route::get('', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('', [CustomerController::class, 'store'])->name('customer.store');
    Route::put('{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('{customer}', [CustomerController::class, 'delete'])->name('customer.delete');

    Route::prefix('pricingBook')->group(function () {
        Route::get('{customer}', [PricingBookController::class, 'index'])->name('pricing-book.index');
        Route::post('{customer}', [PricingBookController::class, 'store'])->name('pricing-book.store');
        Route::post('upload/{customer}', UploadFrameworkController::class)->name('upload.pricing-book');
        Route::delete('{product}', [PricingBookController::class, 'delete'])->name('pricing-book.delete');
    });
});

Route::prefix('vendors')->group(function () {
    Route::get('', [VendorController::class, 'index'])->name('vendor.index');
    Route::post('', [VendorController::class, 'store'])->name('vendor.store');
    Route::put('{vendor}', [VendorController::class, 'update'])->name('vendor.update');
    Route::delete('{vendor}', [VendorController::class, 'delete'])->name('vendor.delete');
});
Route::prefix('riggers')->group(function () {
    Route::get('', [RiggerController::class, 'index'])->name('riggers.index');
    Route::get('download', [RiggerController::class, 'download'])->name('riggers.download');
    Route::post('', [RiggerController::class, 'store'])->name('riggers.store');
    Route::put('{rigger}', [RiggerController::class, 'update'])->name('riggers.update');
    Route::delete('{rigger}', [RiggerController::class, 'destroy'])->name('riggers.delete');
    Route::prefix('profile')->group(function () {
        Route::get('{rigger}', [RiggerController::class, 'show'])->name('rigger.show');
        Route::post('{rigger}', [RiggerController::class, 'upload'])->name('rigger.upload');
        Route::delete('{rigger}/{document}', [RiggerController::class, 'removeDocument'])->name('rigger-document.delete');
    });
});
Route::prefix('users')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('users.index');
    Route::post('', [UserController::class, 'store'])->name('users.store');
    Route::put('{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('{user}', [UserController::class, 'destroy'])->name('users.delete');
});
Route::prefix('settings')->group(function () {
    Route::prefix('measurement_unit')->group(function () {
        Route::get('', [MeasurementUnitController::class, 'index'])->name('measurement.index');
        Route::post('', [MeasurementUnitController::class, 'store'])->name('measurement.store');
        Route::put('{unit)', [MeasurementUnitController::class, 'update'])->name('measurement.update');
        Route::delete('{unit}', [MeasurementUnitController::class, 'delete'])->name('measurement.delete');
    });

    Route::prefix('categories')->group(function () {
        Route::get('', [ProductCategoryController::class, 'index'])->name('category.index');
    });

    Route::prefix('subcategories')->group(function () {
        Route::get('', [SubcategoryController::class, 'index'])->name('subcategory.index');
        Route::post('', [SubcategoryController::class, 'store'])->name('subcategory.store');
    });
    Route::prefix('logs')->group(function () {
        Route::get('', [ActivityLogController::class, 'index'])->name('logs.index');
    });
    Route::prefix('password')->group(function () {
        Route::get('', [UserController::class, 'changePassword'])->name('change.password');
        Route::put('{user}', [UserController::class, 'updatePassword'])->name('update.password');
    });
});

require __DIR__.'/auth.php';
