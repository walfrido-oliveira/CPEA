<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;
use App\Http\Controllers\UserController;
use ChrisKonnertz\StringCalc\StringCalc;
use App\Http\Controllers\UnityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\GuidingValueController;
use App\Http\Controllers\AnalysisOrderController;
use App\Http\Controllers\CampaignStatusCotroller;
use App\Http\Controllers\TemplateEmailController;
use App\Http\Controllers\AnalysisMatrixController;
use App\Http\Controllers\CampaignStatusController;
use App\Http\Controllers\GeodeticSystemController;
use App\Http\Controllers\SampleAnalysisController;
use App\Http\Controllers\PlanActionLevelController;
use App\Http\Controllers\GuidingParameterController;
use App\Http\Controllers\AnalysisParameterController;
use App\Http\Controllers\EnvironmentalAreaController;
use App\Http\Controllers\ParameterAnalysisController;
use App\Http\Controllers\ProjectPointMatrixController;
use App\Http\Controllers\TypeGeodeticSystemController;
use App\Http\Controllers\CalculationVariableController;
use App\Http\Controllers\EnvironmentalAgencyController;
use App\Http\Controllers\PointIdentificationController;
use App\Http\Controllers\CalculationParameterController;
use App\Http\Controllers\GuidingParameterValueController;
use App\Http\Controllers\ParameterAnalysisGroupController;
use App\Http\Controllers\GuidingParameterRefValueController;

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

Route::get('/test', function () {
    $term = "1+3*10/2";
    $stringCalc = new StringCalc();
    $result = $stringCalc->calculate($term);
    dd($result);
})->name('tests');

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

    Route::resource('projetos', ProjectController::class, [
        'names' => 'project'])->parameters([
        'projetos' => 'project'
    ]);
    Route::prefix('projetos')->name('project.')->group(function(){
        Route::post('/filter', [ProjectController::class, 'filter'])->name('filter');
        Route::post('/forgot-password/{user}', [ProjectController::class, 'forgotPassword'])->name('forgot-password');
        Route::get('/duplicate/{project}', [ProjectController::class, 'duplicate'])->name('duplicate');
        Route::post('/status/{project}', [ProjectController::class, 'status'])->name('status');

        Route::resource('ponto-matriz', ProjectPointMatrixController::class, [
            'names' => 'point-matrix'])->parameters([
            'ponto-matriz' => 'point_matrix'
        ]);

        Route::prefix('ponto-matriz')->name('point-matrix.')->group(function(){
            Route::post('/filter', [ProjectPointMatrixController::class, 'filter'])->name('filter');
            Route::post('/update-ajax/{point_matrix}', [ProjectPointMatrixController::class, 'updateAjax'])->name('update-ajax');
            Route::post('/edit-ajax/{point_matrix}', [ProjectPointMatrixController::class, 'editAjax'])->name('edit-ajax');
            Route::post('/list/{project}', [ProjectPointMatrixController::class, 'getPointMatricesByProject'])->name('get-point-matrices-by-project');
            Route::post('/fields/{analysis_matrix}', [ProjectPointMatrixController::class, 'getFields'])->name('get-fields');
            Route::get('/analysis/{campaign}', [ProjectPointMatrixController::class, 'analysis'])->name('analysis');
        });

        Route::resource('campanha', CampaignController::class, [
            'names' => 'campaign'])->parameters([
            'campanha' => 'campaign'
        ]);

        Route::prefix('campanha')->name('campaign.')->group(function(){
            Route::post('/filter', [CampaignController::class, 'filter'])->name('filter');
            Route::post('/update-ajax/{campaign}', [CampaignController::class, 'updateAjax'])->name('update-ajax');
            Route::post('/edit-ajax/{campaign}', [CampaignController::class, 'editAjax'])->name('edit-ajax');
            Route::post('/duplicate/{campaign}', [CampaignController::class, 'duplicate'])->name('duplicate');
            Route::post('/list/{project}', [CampaignController::class, 'getCampaignByProject'])->name('get-campaign-by-project');
        });
    });

    Route::prefix('analise-de-amostra')->name('sample-analysis.')->group(function(){
        Route::get('/', [SampleAnalysisController::class, 'index'])->name('index');
        Route::get('/{campaign}', [SampleAnalysisController::class, 'show'])->name('show');
        Route::get('/historico/{campaign}', [SampleAnalysisController::class, 'historic'])->name('historic');
        Route::post('/filter', [SampleAnalysisController::class, 'filter'])->name('filter');
        Route::post('/filterPointMatrix', [SampleAnalysisController::class, 'filterPointMatrix'])->name('filter-point-matrix');
        Route::post('/carinho', [SampleAnalysisController::class, 'cart'])->name('cart');
        Route::get('/carinho', [SampleAnalysisController::class, 'cart'])->name('cart');
    });

    Route::resource('pedidos-de-analise', AnalysisOrderController::class, [
        'names' => 'analysis-order'])->parameters([
        'pedidos-de-analise' => 'analysis_order'
    ]);

    Route::resource('param-analise', ParameterAnalysisController::class, [
        'names' => 'parameter-analysis'])->parameters([
        'param-analise' => 'parameter_analysis'
    ]);
    Route::prefix('param-analise')->name('parameter-analysis.')->group(function(){
        Route::post('/filter', [ParameterAnalysisController::class, 'filter'])->name('filter');
    });

    Route::resource('param-orientador', GuidingParameterController::class, [
        'names' => 'guiding-parameter'])->parameters([
        'param-orientador' => 'guiding_parameter'
    ]);
    Route::prefix('param-orientador')->name('guiding-parameter.')->group(function(){
        Route::post('/filter', [GuidingParameterController::class, 'filter'])->name('filter');
    });

    Route::resource('ref-vlr-param-orientador', GuidingParameterRefValueController::class, [
        'names' => 'guiding-parameter-ref-value'])->parameters([
        'ref-vlr-param-orientador' => 'guiding_parameter_ref_value'
    ]);
    Route::prefix('ref-vlr-param-orientador')->name('guiding-parameter-ref-value.')->group(function(){
        Route::post('/filter', [GuidingParameterRefValueController::class, 'filter'])->name('filter');
    });

    Route::resource('valor-param-orientador', GuidingParameterValueController::class, [
        'names' => 'guiding-parameter-value'])->parameters([
        'valor-param-orientador' => 'guiding_parameter_value'
    ]);
    Route::prefix('valor-param-orientador')->name('guiding-parameter-value.')->group(function(){
        Route::post('/filter', [GuidingParameterValueController::class, 'filter'])->name('filter');
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
            Route::post('/filter-campaigns', [PointIdentificationController::class, 'filterCampaign'])->name('filter-campaigns');
            Route::post('/filter-customers', [PointIdentificationController::class, 'filterCustomer'])->name('filter-customers');
            Route::post('/filter/{area}', [PointIdentificationController::class, 'filterByArea'])->name('filter-by-area');
            Route::post('/simple-create', [PointIdentificationController::class, 'simpleCreate'])->name('simple-create');
        });

        Route::resource('grupo-param-analise', ParameterAnalysisGroupController::class, [
            'names' => 'parameter-analysis-group'])->parameters([
            'grupo-param-analise' => 'parameter_analysis_group'
        ]);
        Route::prefix('grupo-param-analise')->name('parameter-analysis-group.')->group(function(){
            Route::post('/filter', [ParameterAnalysisGroupController::class, 'filter'])->name('filter');
        });

        Route::resource('status-campanha', CampaignStatusController::class, [
            'names' => 'campaign-status'])->parameters([
            'status-campanha' => 'campaign_status'
        ]);
        Route::prefix('status-campanha')->name('campaign-status.')->group(function(){
            Route::post('/filter', [CampaignStatusController::class, 'filter'])->name('filter');
        });

        Route::resource('matrix-analise', AnalysisMatrixController::class, [
            'names' => 'analysis-matrix'])->parameters([
            'matrix-analise' => 'analysis_matrix'
        ]);
        Route::prefix('matrix-analise')->name('analysis-matrix.')->group(function(){
            Route::post('/filter', [AnalysisMatrixController::class, 'filter'])->name('filter');
        });

        Route::resource('unidades', UnityController::class, [
            'names' => 'unity'])->parameters([
            'unidades' => 'unity'
        ]);
        Route::prefix('unidades')->name('unity.')->group(function(){
            Route::post('/filter', [UnityController::class, 'filter'])->name('filter');
        });

        Route::resource('param-formula-calculo', CalculationParameterController::class, [
            'names' => 'calculation-parameter'])->parameters([
            'param-formula-calculo' => 'calculation-parameter'
        ]);
        Route::prefix('param-formula-calculo')->name('calculation-parameter.')->group(function(){
            Route::post('/filter', [CalculationParameterController::class, 'filter'])->name('filter');
        });

        Route::resource('variavel-formula-calculo', CalculationVariableController::class, [
            'names' => 'calculation-variable'])->parameters([
            'variavel-formula-calculo' => 'calculation-variable'
        ]);
        Route::prefix('variavel-formula-calculo')->name('calculation-variable.')->group(function(){
            Route::post('/filter', [CalculationVariableController::class, 'filter'])->name('filter');
            Route::post('/filter-by-calculation-parameter/{calculation_parameter}', [CalculationVariableController::class, 'filterByCalculationParameter'])->name('filter-by-calculation-parameter');
        });

        Route::resource('laboratorio', LabController::class, [
            'names' => 'lab'])->parameters([
            'laboratorio' => 'lab'
        ]);
        Route::prefix('laboratorio')->name('lab.')->group(function(){
            Route::post('/filter', [LabController::class, 'filter'])->name('filter');
        });

    });
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
