<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// -------------Admin MODULE-----------
Route::any('/user', [App\Http\Controllers\UsersController::class, 'index'])->name('user')->middleware('auth.admin');
Route::post('/create_user', [App\Http\Controllers\UsersController::class, 'create'])->name('create_user');
Route::post('/edit_user_form', [App\Http\Controllers\UsersController::class, 'editForm'])->name('edit_user_form');
Route::post('/edit_user', [App\Http\Controllers\UsersController::class, 'edit'])->name('edit_user');
Route::post('/delete_user', [App\Http\Controllers\UsersController::class, 'destroy'])->name('delete_user');

// -------------Company MODULE-----------
Route::any('/company', [App\Http\Controllers\CompaniesController::class, 'index'])->name('company')->middleware('auth');
Route::any('/company_detail', [App\Http\Controllers\CompaniesController::class, 'detail'])->name('company_detail')->middleware('auth.employee');
Route::post('/create_company', [App\Http\Controllers\CompaniesController::class, 'create'])->name('company_user');
Route::post('/edit_company_form', [App\Http\Controllers\CompaniesController::class, 'editForm'])->name('edit_company_form');
Route::post('/edit_company', [App\Http\Controllers\CompaniesController::class, 'edit'])->name('edit_company');
Route::post('/delete_company', [App\Http\Controllers\CompaniesController::class, 'destroy'])->name('delete_company');

// -------------Employee MODULE-----------
Route::any('/employee', [App\Http\Controllers\EmployeesController::class, 'index'])->name('employee')->middleware('auth');
Route::post('/create_employee', [App\Http\Controllers\EmployeesController::class, 'create'])->name('create_employee');
Route::post('/edit_employee_form', [App\Http\Controllers\EmployeesController::class, 'editForm'])->name('edit_employee_form');
Route::post('/edit_employee', [App\Http\Controllers\EmployeesController::class, 'edit'])->name('edit_employee');
Route::post('/delete_employee', [App\Http\Controllers\EmployeesController::class, 'destroy'])->name('delete_employee');

