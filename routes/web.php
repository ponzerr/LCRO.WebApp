<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\McertController;
use App\Http\Controllers\ManageUserController;

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
Route::controller(ManageUserController::class,)->group(function () {
    Route::get('/manage-users', 'manageUsers')->middleware('can:manage-users');
    Route::get('/manage-users', 'manageUsers')->middleware('can:manage-users')->name('manage-users');
    Route::put('/users/{user}/approve', 'approve')->middleware('can:manage-users')->name('users.approve');
    Route::put('/users/{user}/pend', 'pend')->middleware('can:manage-users')->name('users.pend');
    Route::delete('/users/{user}','destroy')->middleware('can:manage-users')->name('users.destroy');
});

Route::controller(PDFController::class,)->group(function () {
    Route::get('/search','searchall')->middleware('auth')->name('certs.searchall');
    Route::post('/mcerts/generate-pdf/{mcert}','generatePDF')->middleware('auth')->name('mcerts.generatePDF');
    Route::post('/generate-pending-license-report', 'generateReport')->middleware('auth')->name('generate-report');
    Route::post('/generate-approved-license-report', 'generateReportApproved')->middleware('auth')->name('generate-approved-report');
    Route::post('/generate-marriage-legacy-certificate-report', 'generateReportLegacy')->middleware('auth')->name('generate-legacy-report');
    Route::post('/generate-marriage-recent-certificate-report', 'generateReportRecent')->middleware('auth')->name('generate-recent-report');
});

Route::controller(McertController::class,)->group(function () {
    Route::get('/', 'home')->name('mcerts.home');
    Route::get('/mcerts/marriage_license', 'index')->middleware('auth')->name('mcerts.index');
    Route::get('/mcerts/create', 'create')->middleware('auth')->middleware('auth')->name('mcerts.create');
    Route::post('/mcerts/store','store')->middleware('auth')->name('mcerts.store');
    Route::get('/mcerts/show/{mcert}', 'show')->middleware('auth')->name('mcerts.show');
    Route::get('/mcerts/edit/{mcert}', 'edit')->middleware('auth')->name('mcerts.edit');
    Route::put('/mcerts/update/{mcert}', 'update')->middleware('auth')->name('mcerts.update');
    Route::delete('/mcerts/delete/{mcert}', 'destroy')->middleware('auth')->name('mcerts.destroy');
    Route::get('/mcerts/search', 'search')->middleware('auth')->name('mcerts.search');
   

    Route::put('/mcerts/{mcert}/approve', 'approve')->middleware('auth')->name('mcerts.approve');
    Route::put('/mcerts/{mcert}/unapprove', 'unapprove')->middleware('auth')->name('mcerts.unapprove');

    Route::get('/mcerts/insert_legacy_pdf', 'create_mcert_old_file')->middleware('auth')->name('mcerts.pdf');
    Route::post('/mcerts/insert_legacy_pdf','store_mcert_old_file')->middleware('auth')->name('mcerts.pdf.file');
    Route::get('/mcerts/mcerts_legacy_file/show/{mcertFile}', 'show_mcert_old_file')->middleware('auth')->name('mcerts.show_file');
    Route::get('/mcerts/mcerts_legacy_file/search', 'search_mcert_old_file')->middleware('auth')->name('mcerts.search_file');
    Route::post('/mcerts/mcerts_legacy_file/store','store_mcert_old_file')->middleware('auth')->name('mcerts.store_file');
    Route::get('/mcerts/mcerts_legacy_file/marriage_certificates', 'index_mcert_old_file')->middleware('auth')->name('mcerts.index_file');
    Route::delete('/mcerts/mcert_legacy_file/delete/{mcertFile}', 'destroy_mcert_old_file')->middleware('auth')->name('mcerts.destroy_file');
    Route::get('/mcerts/mcert_legacy_file/edit/{mcertFile}', 'edit_mcert_old_file')->middleware('auth')->name('mcerts.edit_file');
    Route::put('/mcerts/mcert_legacy_file/update/{mcertFile}', 'update_mcert_old_file')->middleware('auth')->name('mcerts.update_file');

    Route::get('/mcerts/insert_recent_pdf', 'create_mcert_new_file')->middleware('auth')->name('mcerts.pdf_new');
    Route::post('/mcerts/insert_recent_pdf','store_mcert_new_file')->middleware('auth')->name('mcerts.pdf.file_new');
    Route::get('/mcerts/mcerts_recent_file/show/{mcertNewFile}', 'show_mcert_new_file')->middleware('auth')->name('mcerts.show_new_file');
    Route::get('/mcerts/mcerts_recent_file/search', 'search_mcert_new_file')->middleware('auth')->name('mcerts.search_new_file');
    Route::post('/mcerts/mcerts_recent_file/store','store_mcert_new_file')->middleware('auth')->name('mcerts.store_new_file');
    Route::get('/mcerts/mcerts_recent_file/marriage_certificates', 'index_mcert_new_file')->middleware('auth')->name('mcerts.index_new_file');
    Route::delete('/mcerts/mcert_recent_file/delete/{mcertNewFile}', 'destroy_mcert_new_file')->middleware('auth')->name('mcerts.destroy_new_file');
    Route::get('/mcerts/mcert_recent_file/edit/{mcertNewFile}', 'edit_mcert_new_file')->middleware('auth')->name('mcerts.edit_new_file');
    Route::put('/mcerts/mcert_recent_file/update/{mcertNewFile}', 'update-mcert_new_file')->middleware('auth')->name('mcerts.update_new_file');

    Route::get('/mcerts/insert_application_pdf', 'create_mcert_app_file')->middleware('auth')->name('mcerts.pdf_app');
    Route::post('/mcerts/insert_application_pdf','store_mcert_app_file')->middleware('auth')->name('mcerts.pdf.file_app');
    Route::get('/mcerts/mcerts_application_file/show/{mcertAppFile}', 'show_mcert_app_file')->middleware('auth')->name('mcerts.show_app_file');
    Route::get('/mcerts/mcerts_application_file/search', 'search_mcert_app_file')->middleware('auth')->name('mcerts.search_app_file');
    Route::post('/mcerts/mcerts_application_file/store','store_mcert_app_file')->middleware('auth')->name('mcerts.store_app_file');
    Route::get('/mcerts/mcerts_application_file/marriage_certificates', 'index_mcert_app_file')->middleware('auth')->name('mcerts.index_app_file');
    Route::delete('/mcerts/mcert_application_file/delete/{mcertAppFile}', 'destroy_mcert_app_file')->middleware('auth')->name('mcerts.destroy_app_file');
    Route::get('/mcerts/mcert_application_file/edit/{mcertAppFile}', 'edit_mcert_app_file')->middleware('auth')->name('mcerts.edit_app_file');
    Route::put('/mcerts/mcert_application_file/update/{mcertAppFile}', 'update-mcert_app_file')->middleware('auth')->name('mcerts.update_app_file');
});

Route::get('/assign-role', function () {
    $user = User::find(1);
    $user->role = 'admin';
    $user->save();

    // Additional code or response
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
