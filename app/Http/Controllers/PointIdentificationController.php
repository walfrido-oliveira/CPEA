<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GeodeticSystem;
use Illuminate\Validation\Rule;
use App\Models\PointIdentification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PointIdentificationRequest;

class PointIdentificationController extends Controller
{
    /**
     * Display a listing of the point identification.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pointIdentifications =  PointIdentification::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';

        return view('point-identification.index', compact('pointIdentifications', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $geodeticSystems = GeodeticSystem::pluck("name", "id");
        return view('point-identification.create', compact('geodeticSystems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PointIdentificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PointIdentificationRequest $request)
    {
        $input = $request->all();

        $pointIdentification =   PointIdentification::create([
            'area' => $input['area'],
            'identification' => $input['identification'],
            'geodetic_system_id' => $input['geodetic_system_id'],
            'utm_me_coordinate' => isset($input['utm_me_coordinate']) ? $input['utm_me_coordinate'] : null,
            'utm_mm_coordinate' => isset($input['utm_mm_coordinate']) ? $input['utm_mm_coordinate'] : null,
            'pool_depth' => isset($input['pool_depth']) ? $input['pool_depth'] : null,
            'pool_diameter' => isset($input['pool_diameter']) ? $input['pool_diameter'] : null,
            'pool_volume' => isset($input['pool_volume']) ? $input['pool_volume'] : null,
            'water_depth' => isset($input['water_depth']) ? $input['water_depth'] : null,
            'sedimentary_collection_depth' => isset($input['sedimentary_collection_depth']) ? $input['sedimentary_collection_depth'] : null,
            'collection_depth' => isset($input['collection_depth']) ? $input['collection_depth'] : null,
            'water_collection_depth' => isset($input['water_collection_depth']) ? $input['water_collection_depth'] : null,
        ]);

        $resp = [
            'message' => __('Ponto Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        if(!isset($input['no-redirect']))
            return redirect()->route('registers.point-identification.index')->with($resp);
        else
            return response()->json($resp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function simpleCreate(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'area' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:255',
            Rule::unique('point_identifications')->where(function ($query) use($request) {
                return $query->where('area', $request->get('area'))
                             ->where('identification', $request->get('identification'));
            })],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $pointIdentification =   PointIdentification::create([
            'area' => $input['area'],
            'identification' => $input['identification'],
            'geodetic_system_id' => isset($input['geodetic_system_id']) ? $input['geodetic_system_id'] : null,
            'utm_me_coordinate' => isset($input['utm_me_coordinate']) ? $input['utm_me_coordinate'] : null,
            'utm_mm_coordinate' => isset($input['utm_mm_coordinate']) ? $input['utm_mm_coordinate'] : null,
            'pool_depth' => isset($input['pool_depth']) ? $input['pool_depth'] : null,
            'pool_diameter' => isset($input['pool_diameter']) ? $input['pool_diameter'] : null,
            'pool_volume' => isset($input['pool_volume']) ? $input['pool_volume'] : null,
            'water_depth' => isset($input['water_depth']) ? $input['water_depth'] : null,
            'sedimentary_collection_depth' => isset($input['sedimentary_collection_depth']) ? $input['sedimentary_collection_depth'] : null,
            'collection_depth' => isset($input['collection_depth']) ? $input['collection_depth'] : null,
            'water_collection_depth' => isset($input['water_collection_depth']) ? $input['water_collection_depth'] : null,
        ]);

        $resp = [
            'message' => __('Ponto Cadastrado com Sucesso!'),
            'alert-type' => 'success',
            'point_identifications' => PointIdentification::groupBy('area')->get()
        ];

        Cache::forget('areas');

        if(!isset($input['no-redirect']))
            return redirect()->route('registers.point-identification.index')->with($resp);
        else
            return response()->json($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);
        $customers = $pointIdentification->customers()->paginate(DEFAULT_PAGINATE_PER_PAGE, ['*'], 'customers')->appends(request()->input());
        $projectCampaigns = $pointIdentification->campaigns()->paginate(DEFAULT_PAGINATE_PER_PAGE, ['*'], 'campaigns')->appends(request()->input());

        return view('point-identification.show', compact('pointIdentification', 'customers', 'projectCampaigns'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);
        $geodeticSystems = GeodeticSystem::pluck("name", "id");
        return view('point-identification.edit', compact('pointIdentification', 'geodeticSystems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PointIdentificationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PointIdentificationRequest $request, $id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);

        $input = $request->all();

        $pointIdentification->update([
            'area' => $input['area'],
            'identification' => $input['identification'],
            'geodetic_system_id' => $input['geodetic_system_id'],
            'utm_me_coordinate' => isset($input['utm_me_coordinate']) ? $input['utm_me_coordinate'] : null,
            'utm_mm_coordinate' => isset($input['utm_mm_coordinate']) ? $input['utm_mm_coordinate'] : null,
            'pool_depth' => isset($input['pool_depth']) ? $input['pool_depth'] : null,
            'pool_diameter' => isset($input['pool_diameter']) ? $input['pool_diameter'] : null,
            'pool_volume' => isset($input['pool_volume']) ? $input['pool_volume'] : null,
            'water_depth' => isset($input['water_depth']) ? $input['water_depth'] : null,
            'sedimentary_collection_depth' => isset($input['sedimentary_collection_depth']) ? $input['sedimentary_collection_depth'] : null,
            'collection_depth' => isset($input['collection_depth']) ? $input['collection_depth'] : null,
            'water_collection_depth' => isset($input['water_collection_depth']) ? $input['water_collection_depth'] : null,
        ]);

        $resp = [
            'message' => __('Ponto Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.point-identification.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);

        $pointIdentification->delete();

        return response()->json([
            'message' => __('Ponto Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter Plan Action Level
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $pointIdentifications = PointIdentification::filter($request->all());
        $pointIdentifications = $pointIdentifications->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('point-identification.filter-result', compact('pointIdentifications', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $pointIdentifications,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }

    /**
     * Filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterCustomer(Request $request)
    {
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        $customers = PointIdentification::findOrFail($request->get('point_identification_id'))->customers();
        if($request->has('name')) $customers->where('name', $request->get('name'));

        $customers = $customers->orderBy($orderBy, $ascending);

        $customers = $customers->paginate($paginatePerPage, ['*'], 'customers');

        $actions = $request->has('actions') ? $request->get('actions') : 'show';

        return response()->json([
            'filter_result' => view('customers.filter-result', compact('customers', 'orderBy', 'ascending', 'actions'))->render(),
            'pagination' => $this->setPagination($customers, $orderBy, $ascending, $paginatePerPage),
        ]);
    }

    /**
     * Filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterCampaign(Request $request)
    {
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        $projectCampaigns = PointIdentification::findOrFail($request->get('point_identification_id'))->campaigns();
        if($request->has('name')) $projectCampaigns->where('name', $request->get('name'));

        $projectCampaigns = $projectCampaigns->with('project')
        ->leftJoin('projects', 'projects.id', '=', 'campaigns.project_id')
        ->select('campaigns.*')
        ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
        ->join('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
        ->join('analysis_matrices', 'analysis_matrices.id', '=', 'project_point_matrices.analysis_matrix_id')
        ->orderBy($orderBy, $ascending);

        $projectCampaigns = $projectCampaigns->paginate($paginatePerPage, ['*'], 'campaigns');

        $actions = $request->has('actions') ? $request->get('actions') : 'show';

        return response()->json([
            'filter_result' => view('point-identification.filter-result-point', compact('projectCampaigns', 'orderBy', 'ascending', 'actions'))->render(),
            'pagination' => $this->setPagination($projectCampaigns, $orderBy, $ascending, $paginatePerPage),
        ]);
    }

    /**
     * Filter by area
     * @param String $area
     * @return \Illuminate\Http\Response
     */
    public function filterByArea($area)
    {
        $pointIdentifications = PointIdentification::where('area', $area)->get();

        return response()->json([
            'point_identifications' => $pointIdentifications,
        ]);
    }

     /**
     * @param Collection $projectCampaigns
     * @param string $orderBy
     * @param string $ascending
     * @param string $paginatePerPage
     *
     * @return view
     */
    private function setPagination($projectCampaigns, $orderBy, $ascending, $paginatePerPage)
    {
        return view('layouts.pagination', [
            'models' => $projectCampaigns,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginatePerPage,
            ])->render();
    }
}
