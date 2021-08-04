<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PointIdentification;
use App\Http\Requests\CustomerRequest;

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
        return view('customers.index', compact('customers'));
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

        $resp = [
            'message' => __('Cliente cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.index')->with($resp);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

        return response()->json([
            'filter_result' => view('customers.filter-result', compact('customers'))->render(),
            'pagination' => view('layouts.pagination', ['models' => $customers])->render(),
        ]);
    }

}
