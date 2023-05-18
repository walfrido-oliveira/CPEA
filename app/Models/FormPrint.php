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
        $this->refs = collect();
        $this->externalRefs = collect();

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
            "sat" => null,
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
            "chlorine" => Config::get("form_chlorine_range"),
            "residualchlorine" => Config::get("form_residualchlorine_range"),
            "aspect" => Config::get("form_aspect_range"),
            "artificialdyes" => Config::get("form_artificialdyes_range"),
            "floatingmaterials" => Config::get("form_floatingmaterials_range"),
            "objectablesolidwaste" => Config::get("form_objectablesolidwaste_range"),
            "visibleoilsandgreases" => Config::get("form_visibleoilsandgreases_range"),
            "voc" => Config::get("form_voc_range"),
        ];

        if($this->formValue->form->name == 'RT-LAB-041-191') {
            $this->parameters["chlorine"] = "Cloro Total";
            $this->parameters["residualchlorine"] = "Cloro Livre Residual";
            $this->parameters["aspect"] = "Aspecto";
            $this->parameters["artificialdyes"] = "Corantes Artificiais";
            $this->parameters["floatingmaterials"] = "Materiais Flutuantes";
            $this->parameters["objectablesolidwaste"] = "Resíduos Sólidos Objetáveis";
            $this->parameters["visibleoilsandgreases"] = "Óleos e Graxas Visíveis";
            $this->parameters["voc"] = "VOC";

            $this->unities["chlorine"] = "mg/L";
            $this->unities["residualchlorine"] = "mg/L";
            $this->unities["aspect"] = "-";
            $this->unities["artificialdyes"] = "-";
            $this->unities["floatingmaterials"] = "-";
            $this->unities["objectablesolidwaste"] = "-";
            $this->unities["visibleoilsandgreases"] = "-";
            $this->unities["voc"] = "ppm";

            $this->LQ["chlorine"] = Config::get("form_chlorine_lq");
            $this->LQ["residualchlorine"] = Config::get("form_residualchlorine_lq");
            $this->LQ["aspect"] = "-";
            $this->LQ["artificialdyes"] = "-";
            $this->LQ["floatingmaterials"] = "-";
            $this->LQ["objectablesolidwaste"] = "-";
            $this->LQ["visibleoilsandgreases"] = "-";
            $this->LQ["voc"] = Config::get("form_voc_lq");

            $this->places["chlorine"] = intval(Config::get("form_chlorine_places"));
            $this->places["residualchlorine"] = intval(Config::get("form_residualchlorine_places"));
            $this->places["aspect"] = "";
            $this->places["artificialdyes"] = "";
            $this->places["floatingmaterials"] = "";
            $this->places["objectablesolidwaste"] = "";
            $this->places["visibleoilsandgreases"] = "";
            $this->places["voc"] = intval(Config::get("form_voc_places"));

            $this->range["chlorine"] = Config::get("form_chlorine_range");
            $this->range["residualchlorine"] = Config::get("form_residualchlorine_range");
            $this->range["aspect"] = Config::get("form_aspect_range");
            $this->range["artificialdyes"] = Config::get("form_artificialdyes_range");
            $this->range["floatingmaterials"] = Config::get("form_floatingmaterials_range");
            $this->range["objectablesolidwaste"] = Config::get("form_objectablesolidwaste_range");
            $this->range["visibleoilsandgreases"] = Config::get("form_visibleoilsandgreases_range");
            $this->range["voc"] = Config::get("form_voc_range");
        }

        if($this->formValue->form->name != 'RT-LAB-041-191') {
            foreach ($this->parameters as $key => $value) {
                if(($key != "ntu") || ($key == "ntu" && isset($this->formValue->values['turbidity']))) {
                    $this->getRefs($key);
                }
            }
        } else {
            foreach ($this->parameters as $key => $value) {
                if(isset($formValue->values[$key . "_column"])) {
                    $this->getRefs("temperature");
                }
            }
        }


        if ($this->formValue->formRevs()->latest()->first()) {
            $this->lastRev = $this->formValue->formRevs()->latest()->first();
        }

    }

    /**
     *
     * @return Array
     */
    private function getRefs($key)
    {
        $refs = Ref::where('field_type_id', $this->formValue->values['matrix'])
        ->where("type", "Referências")
        ->get();

        $externalRefs = Ref::where('field_type_id', $this->formValue->values['matrix'])
        ->where("type", "Referência Externa")
        ->get();
        foreach ($refs as $ref) {
            if(is_array($ref->params)) {
                if(in_array($key, $ref->params) && !$this->refs->contains('id', '=', $ref->id)) {
                    $this->refs[] = $ref;
                }
            }
        }

        foreach ($externalRefs as $externalRef) {
            if(is_array($externalRef->params)) {
                if(in_array($key, $externalRef->params) && !$this->externalRefs->contains('id', '=', $externalRef->id)) {
                    $this->externalRefs[] = $externalRef;
                }
            }
        }


    }

}
