<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Requests\ConfigRequest;
use Illuminate\Support\Facades\Redirect;

class FormConfigController extends Controller
{
    /**
     * Show the form for editing the Config.
     *
     * @param  @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logo = Config::get('form_logo');
        $cert = Config::get('form_cert');
        $header = Config::get('form_header');
        $footer = Config::get('form_footer');
        $additionalInfo = Config::get('form_additional_info');
        $approvalText = Config::get('form_approval_text');
        $uncertaintyText = Config::get('form_uncertainty_text');

        return view('form-values.config.index', compact('logo', 'cert', 'header', 'footer', 'additionalInfo', 'approvalText', 'uncertaintyText'));
    }

    /**
     * Update config in storage.
     *
     * @param  ConfigRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigRequest $request)
    {
        $data = $request->except('_method', '_token', 'logo', 'cert');

        $logo = null;
        $logoPath = null;
        $cert = null;
        $certPath = null;

        if($request->logo) {
            $logo = time().'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('storage/img/'), $logo);
            $logoPath = 'storage/img/'. $logo;
            Config::add('form_logo', $logoPath, Config::getDataType('form_logo'));
        }

        if($request->cert) {
            $cert = time().'.'.$request->cert->getClientOriginalExtension();
            $request->cert->move(public_path('storage/img/'), $cert);
            $certPath = 'storage/img/'. $cert;
            Config::add('form_cert', $certPath, Config::getDataType('form_cert'));
        }


        foreach ($data as $key => $val) {
            Config::add($key, $val, Config::getDataType($key));
        }

        $notification = array(
            'message' => 'Configurações salvas com sucesso!',
            'alert-type' => 'success'
        );

        return Redirect::to(route('fields.config.index'))->with($notification);
    }
}
