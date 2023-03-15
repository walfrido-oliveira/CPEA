<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormPrint extends Model
{
    use HasFactory;

    public  $formValue;

    public $pathLogo;
    public $pathCert;
    public $header;
    public $footer;
    public $uncertaintyText;
    public $pathSigner;
    public $logo;
    public $crl;
    public $signer;
    public $lastRev;

    public $user;
    public Customer $customer;

    public $parameters;
    public $unities;
    public $LQ;
    public $places;
    public $range;

    public $refs;
    public $externalRefs;

    public $signerFile;

    function __construct(FormValue $formValue, $signerFile = false)
    {
        $this->formValue = $formValue;

        $this->signerFile = $signerFile;

        $this->pathLogo = Config::get("form_logo");
        $this->pathCert = Config::get("form_cert");
        $this->header = Config::get("form_header");
        $this->footer = Config::get("form_footer");
        $this->uncertaintyText = Config::get('form_uncertainty_text');

        if(isset($this->formValue->values["signer"])) {
            $this->user = User::find($this->formValue->values["signer"]);
            $this->pathSigner = $this->user ? $this->user->signer : null;
        } else {
            $this->user = User::find(0);
        }

        if(isset($this->formValue->values['client'])) $this->customer = Customer::find($this->formValue->values['client']);

        $this->logo = File::exists($this->pathLogo) ? base64_encode(file_get_contents($this->pathLogo)) : null;
        $this->crl = File::exists($this->pathCert) ? base64_encode(file_get_contents($this->pathCert)) : null;
        $this->signer = File::exists($this->pathSigner) ? base64_encode(file_get_contents($this->pathSigner)) : null;

        $this->parameters = [
            "conc" => "OD",
            "orp" => "ORP",
            "ph" => "pH",
            "conductivity" => "Condutividade",
            "salinity" => "Salinidade",
            "temperature" => "Temperatura",
            "ntu" => "Turbidez",
        ];

        $this->unities = [
            "temperature" => "°C",
            "ph" => "-",
            "orp" => "mV",
            "conductivity" => "µS/cm",
            "salinity" => "-",
            "conc" => "mg/L",
            "ntu" => "NTU",
        ];

        $this->LQ = [
            "temperature" => Config::get("form_temperature_lq"),
            "ph" => Config::get("form_ph_lq"),
            "orp" => Config::get("form_orp_lq"),
            "conductivity" => Config::get("form_conductivity_lq"),
            "salinity" => Config::get("form_salinity_lq"),
            "conc" => Config::get("form_conc_lq"),
            "ntu" => Config::get("form_ntu_lq"),
            "eh" => null,
            "sat" => null
        ];

        $this->places = [
            "temperature" => intval(Config::get("form_temperature_places")),
            "ph" => intval(Config::get("form_ph_places")),
            "orp" => intval(Config::get("form_orp_places")),
            "conductivity" => intval(Config::get("form_conductivity_places")),
            "salinity" => intval(Config::get("form_salinity_places")),
            "conc" => intval(Config::get("form_conc_places")),
            "psi" => intval(Config::get("form_psi_places")),
            "sat" => intval(Config::get("form_sat_places")),
            "eh" => intval(Config::get("form_eh_places")),
            "ntu" => intval(Config::get("form_ntu_places")),
        ];

        $this->range = [
            "temperature" => Config::get("form_temperature_range"),
            "ph" => Config::get("form_ph_range"),
            "orp" => Config::get("form_orp_range"),
            "conductivity" => Config::get("form_conductivity_range"),
            "salinity" => Config::get("form_salinity_range"),
            "conc" => Config::get("form_conc_range"),
            "ntu" => Config::get("form_ntu_range"),
        ];

        if(isset($this->formValue->values['turbidity'])) {
            $this->refs = Ref::where('field_type_id', $this->formValue->values['matrix'])
            ->where("type", "Referências")
            ->get();

            $this->externalRefs = Ref::where('field_type_id', $this->formValue->values['matrix'])
            ->where("type", "Referência Externa")
            ->get();

        } else {
            $this->refs = Ref::where('field_type_id', $this->formValue->values['matrix'])
            ->where("type", "Referências")
            ->where("turbidity", false)
            ->get();

            $this->externalRefs = Ref::where('field_type_id', $this->formValue->values['matrix'])
            ->where("type", "Referência Externa")
            ->where("turbidity", false)
            ->get();
        }

        if ($this->formValue->formRevs()->latest()->first()) {
            $this->lastRev = $this->formValue->formRevs()->latest()->first();
        }

    }

}
