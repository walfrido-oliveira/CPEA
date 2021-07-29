<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\TemplateEmailController;
use App\Http\Controllers\GeodeticSystemController;
use App\Http\Controllers\PlanActionLevelController;
use App\Http\Controllers\EnvironmentalAreaController;
use App\Http\Controllers\TypeGeodeticSystemController;

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

    Route::resource('users', UserController::class);

    Route::prefix('users')->name('users.')->group(function(){
        Route::post('/filter', [UserController::class, 'filter'])->name('filter');
        Route::post('/forgot-password/{user}', [UserController::class, 'forgotPassword'])->name('forgot-password');
    });

    Route::prefix('config')->name('config.')->group(function(){
        Route::prefix('emails')->name('emails.')->group(function(){
            Route::get('/', [EmailConfigController::class, 'index'])->name('index');
            Route::post('/store', [EmailConfigController::class, 'store'])->name('store');
            Route::resource('templates', TemplateEmailController::class);
            Route::get('templates/mail-preview/{template}', [TemplateEmailController::class, 'show'])->name("templates.mail-preview");
        });
    });

    Route::prefix('cadastros')->name('registers.')->group(function(){
        Route::resource('geodesico', GeodeticSystemController::class, [
            'names' => 'geodetics'])->parameters([])->parameters([
            'geodesico' => 'geodetic'
        ]);
        Route::prefix('geodesico')->name('geodetics.')->group(function(){
            Route::post('/filter', [GeodeticSystemController::class, 'filter'])->name('filter');
        });

        Route::resource('area-ambiental', EnvironmentalAreaController::class, [
            'names' => 'environmental-area'])->parameters([
            'area-ambiental' => 'environmental_area'
        ]);
        Route::prefix('area-ambiental')->name('environmental-area.')->group(function(){
            Route::post('/filter', [EnvironmentalAreaController::class, 'filter'])->name('filter');
        });

        Route::resource('nivel-acao-plano', PlanActionLevelController::class, [
            'names' => 'plan-action-level'])->parameters([
            'nivel-acao-plano' => 'plan_action_level'
        ]);
        Route::prefix('nivel-acao-plano')->name('plan-action-level.')->group(function(){
            Route::post('/filter', [PlanActionLevelController::class, 'filter'])->name('filter');
        });

    });
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
