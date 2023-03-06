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
    public $pathSigner;
    public $logo;
    public $crl;
    public $signer;
    public $lastRev;

    public User $user;
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

        $this->user = isset($this->formValue->values["responsible"]) ? User::find($this->formValue->values["responsible"]) : null;
        $this->customer = isset($this->formValue->values['client']) ? Customer::find($this->formValue->values['client']) : null;

        $this->pathSigner = $this->user ? $this->user->signer : null;

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
        ];

        $this->unities = [
            "temperature" => "°C",
            "ph" => "-",
            "orp" => "mV",
            "conductivity" => "µS/cm",
            "salinity" => "-",
            "conc" => "mg/L",
        ];

        $this->LQ = [
            "temperature" => "-",
            "ph" => "-",
            "orp" => "-",
            "conductivity" => "20",
            "salinity" => "0,01",
            "conc" => "0,3",
        ];

        $this->places = [
            "temperature" => 2,
            "ph" => 2,
            "orp" => 1,
            "conductivity" => 3,
            "salinity" => 3,
            "conc" => 3,
        ];

        $this->range = [
            "temperature" => "4 a 40",
            "ph" => "1 a 13",
            "orp" => "-1400 a +1400",
            "conductivity" => "-",
            "salinity" => "-",
            "conc" => "-"
        ];

        if(isset($this->formValue->values['turbidity'])) {
            $this->range["ntu"] = "-";
            $this->places["ntu"] = 1;
            $this->LQ["ntu"] = "";
            $this->unities["ntu"] = "NTU";
            $this->parameters["ntu"] = "Turbidez";

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
