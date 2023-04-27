<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ContactTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\TemplateEmailController;

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
    return redirect()->route('login');
})->name('home');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {

    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('usuarios', UserController::class, [
        'names' => 'users'])->parameters([
        'usuarios' => 'user'
    ]);
    Route::prefix('usuarios')->name('users.')->group(function(){
        Route::post('/filter', [UserController::class, 'filter'])->name('filter');
        Route::post('/forgot-password/{user}', [UserController::class, 'forgotPassword'])->name('forgot-password');
    });

    Route::prefix('config')->name('config.')->group(function(){
        Route::get('/', [ConfigController::class, 'index'])->name('index');
        Route::post('/store', [ConfigController::class, 'store'])->name('store');

        Route::prefix('emails')->name('emails.')->group(function(){
            Route::get('/', [EmailConfigController::class, 'index'])->name('index');
            Route::post('/store', [EmailConfigController::class, 'store'])->name('store');
            Route::resource('templates', TemplateEmailController::class);
            Route::get('templates/mail-preview/{template}', [TemplateEmailController::class, 'show'])->name("templates.mail-preview");
        });
    });

    Route::resource('departamentos', DepartmentController::class, [
        'names' => 'departments'])->parameters([
        'departamentos' => 'department'
    ]);

    Route::prefix('departamentos')->name('departments.')->group(function(){
        Route::post('/filter', [DepartmentController::class, 'filter'])->name('filter');
    });

    Route::resource('cargos', OccupationController::class, [
        'names' => 'occupations'])->parameters([
        'cargos' => 'occupation'
    ]);

    Route::prefix('cargos')->name('occupations.')->group(function(){
        Route::post('/filter', [OccupationController::class, 'filter'])->name('filter');
    });

    Route::resource('diretorias', DirectionController::class, [
        'names' => 'directions'])->parameters([
        'diretorias' => 'direction'
    ]);

    Route::prefix('diretorias')->name('directions.')->group(function(){
        Route::post('/filter', [DirectionController::class, 'filter'])->name('filter');
    });

    Route::resource('tipo-contato', ContactTypeController::class, [
        'names' => 'contact-types'])->parameters([
        'tipo-contato' => 'contact_type'
    ]);

    Route::prefix('tipo-contato')->name('contact-types.')->group(function(){
        Route::post('/filter', [ContactTypeController::class, 'filter'])->name('filter');
    });

});


