<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PointIdentification;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
    * Display a listing of the customer.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';
        $actions = isset($query['actions']) ? $query['actions'] : 'show';

        return view('customers.index', compact('customers', 'ascending', 'orderBy', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Customer::getStatusArray();
        $areas = PointIdentification::pluck('area', 'area');

        return view('customers.create', compact('status', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $input = $request->all();

        $customer = Customer::create([
            'name' => $input['name'],
            'status' => $input['status'],
        ]);

        $customer->pointIdentifications()->sync(isset($input['point_identification']) ? $input['point_identification'] : []);

        if($request->ajax()){
            return "AJAX";
        }

        $resp = [
            'message' => __('Cliente cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.index')->with($resp);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function simpleCreate(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $customer = Customer::create([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Cliente cadastrado com Sucesso!'),
            'alert-type' => 'success',
            'customers' => Customer::where('status', 'active')->orderBy("name")->get()
        ];

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
        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $status = Customer::getStatusArray();
        $areas = PointIdentification::pluck('area', 'area');

        return view('customers.edit', compact('customer', 'status', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $customer = Customer::findOrFail($id);

        $customer->update([
            'name' => $input['name'],
            'status' => $input['status'],
        ]);

        $customer->pointIdentifications()->sync(isset($input['point_identification']) ? $input['point_identification'] : []);

        $resp = [
            'message' => __('Cliente atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Customer::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => __('Cliente Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter Customer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $customers = Customer::filter($request->all());
        $customers = $customers->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');
        $actions = $request->has('actions') ? $request->get('actions') : 'show';

        return response()->json([
        'filter_result' => view('customers.filter-result', compact('customers', 'orderBy', 'ascending', 'actions'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $customers,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }

}
