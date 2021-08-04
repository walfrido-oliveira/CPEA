<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\GuidingValueController;
use App\Http\Controllers\TemplateEmailController;
use App\Http\Controllers\GeodeticSystemController;
use App\Http\Controllers\PlanActionLevelController;
use App\Http\Controllers\AnalysisParameterController;
use App\Http\Controllers\EnvironmentalAreaController;
use App\Http\Controllers\TypeGeodeticSystemController;
use App\Http\Controllers\EnvironmentalAgencyController;
use App\Http\Controllers\PointIdentificationController;

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

    Route::resource('usuarios', UserController::class, [
        'names' => 'users'])->parameters([
        'usuarios' => 'user'
    ]);

    Route::prefix('usuarios')->name('users.')->group(function(){
        Route::post('/filter', [UserController::class, 'filter'])->name('filter');
        Route::post('/forgot-password/{user}', [UserController::class, 'forgotPassword'])->name('forgot-password');
    });

    Route::resource('clientes', CustomerController::class, [
        'names' => 'customers'])->parameters([
        'clientes' => 'customer'
    ]);

    Route::prefix('clientes')->name('customers.')->group(function(){
        Route::post('/filter', [CustomerController::class, 'filter'])->name('filter');
        Route::post('/forgot-password/{user}', [CustomerController::class, 'forgotPassword'])->name('forgot-password');
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

        Route::resource('valor-orientador', GuidingValueController::class, [
            'names' => 'guiding-value'])->parameters([
            'valor-orientador' => 'guiding_value'
        ]);
        Route::prefix('valor-orientador')->name('guiding-value.')->group(function(){
            Route::post('/filter', [GuidingValueController::class, 'filter'])->name('filter');
        });

        Route::resource('orgao-ambiental', EnvironmentalAgencyController::class, [
            'names' => 'environmental-agency'])->parameters([
            'orgao-ambiental' => 'environmental_agency'
        ]);
        Route::prefix('orgao-ambiental')->name('environmental-agency.')->group(function(){
            Route::post('/filter', [EnvironmentalAgencyController::class, 'filter'])->name('filter');
        });

        Route::resource('param-analise', AnalysisParameterController::class, [
            'names' => 'analysis-parameter'])->parameters([
            'param-analise' => 'analysis_parameter'
        ]);
        Route::prefix('param-analise')->name('analysis-parameter.')->group(function(){
            Route::post('/filter', [AnalysisParameterController::class, 'filter'])->name('filter');
        });

        Route::resource('ponto', PointIdentificationController::class, [
            'names' => 'point-identification'])->parameters([
            'ponto' => 'point_identification'
        ]);
        Route::prefix('ponto')->name('point-identification.')->group(function(){
            Route::post('/filter', [PointIdentificationController::class, 'filter'])->name('filter');
            Route::post('/filter/{area}', [PointIdentificationController::class, 'filterByArea'])->name('filter-by-area');
        });

    });
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
