<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'values', 'form_id', 'signed'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'values' => 'array',
        'signed' => 'boolean',
    ];

    /**
     * Get field type
     *
     * @return array
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * The Revs.
     */
    public function formRevs()
    {
        return $this->HasMany(FormRev::class);
    }

    /**
     * Find in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

        $envionmentalAreas = self::where(function ($q) use ($query) {
            if (isset($query['id'])) {
                if (!is_null($query['id'])) {
                    $q->where('id', $query['id']);
                }
            }

            if (isset($query['form_id'])) {
                if (!is_null($query['form_id'])) {
                    $q->where('form_id', $query['form_id']);
                }
            }

            if (isset($query['project_id'])) {
                if (!is_null($query['project_id'])) {
                    $q->where('values', 'like', '%' . $query['project_id'] . '%');
                }
            }
        });

        $envionmentalAreas->orderBy($orderBy, $ascending);

        return $envionmentalAreas->paginate($perPage);
    }

    public function getDPRAttribute()
    {
        $dpr = [];
        $svgs = $this->svgs;
        $duplicates = $this->duplicates;
        $duplicatesSvgs = $this->duplicatesSvgs;

        if (isset($this->values["samples"])) {
            foreach ($this->values["samples"] as $key => $sample) {
                if (isset($sample["results"])) {
                    if (isset(array_chunk($sample["results"], 3)[1])) {
                        if ($svgs[$key]["temperature"] != 0) {
                            $dpr[$key]["temperature"] = (($svgs[$key]["temperature"] - $duplicates[$key]["temperature"]) / $duplicatesSvgs[$key]["temperature"]) * 100;
                        }
                        if ($svgs[$key]["ph"] != 0) {
                            $dpr[$key]["ph"] = (($svgs[$key]["ph"] - $duplicates[$key]["ph"]) / $duplicatesSvgs[$key]["ph"]) * 100;
                        }
                        if ($svgs[$key]["orp"] != 0) {
                            $dpr[$key]["orp"] = (($svgs[$key]["orp"] - $duplicates[$key]["orp"]) / $duplicatesSvgs[$key]["orp"]) *  100;
                        }
                        if ($svgs[$key]["conductivity"] != 0) {
                            $dpr[$key]["conductivity"] = (($svgs[$key]["conductivity"] - $duplicates[$key]["conductivity"]) / $duplicatesSvgs[$key]["conductivity"]) * 100;
                        }
                        if ($svgs[$key]["salinity"] != 0) {
                            $dpr[$key]["salinity"] = (($svgs[$key]["salinity"] - $duplicates[$key]["salinity"]) / $duplicatesSvgs[$key]["salinity"]) * 100;
                        }
                        if ($svgs[$key]["psi"] != 0) {
                            $dpr[$key]["psi"] = (($svgs[$key]["psi"] - $duplicates[$key]["psi"]) / $duplicatesSvgs[$key]["psi"]) * 100;
                        }
                        if ($svgs[$key]["sat"] != 0) {
                            $dpr[$key]["sat"] = (($svgs[$key]["sat"] - $duplicates[$key]["sat"]) / $duplicatesSvgs[$key]["sat"]) * 100;
                        }
                        if ($svgs[$key]["conc"] != 0) {
                            $dpr[$key]["conc"] = (($svgs[$key]["conc"] - $duplicates[$key]["conc"]) / $duplicatesSvgs[$key]["conc"]) * 100;
                        }
                        if ($svgs[$key]["eh"] != 0) {
                            $dpr[$key]["eh"] = (($svgs[$key]["eh"] - $duplicates[$key]["eh"]) / $duplicatesSvgs[$key]["eh"]) * 100;
                        }
                        if ($svgs[$key]["ntu"] != 0) {
                            $dpr[$key]["ntu"] = (($svgs[$key]["ntu"] - $duplicates[$key]["ntu"]) / $duplicatesSvgs[$key]["ntu"]) * 100;
                        }
                        if ($svgs[$key]["chlorine"] != 0) {
                            $dpr[$key]["chlorine"] = (($svgs[$key]["chlorine"] - $duplicates[$key]["chlorine"]) / $duplicatesSvgs[$key]["chlorine"]) * 100;
                        }
                        if ($svgs[$key]["residualchlorine"] != 0) {
                            $dpr[$key]["residualchlorine"] = (($svgs[$key]["residualchlorine"] - $duplicates[$key]["residualchlorine"]) / $duplicatesSvgs[$key]["residualchlorine"]) * 100;
                        }
                        if ($svgs[$key]["voc"] != 0) {
                            $dpr[$key]["voc"] = (($svgs[$key]["voc"] - $duplicates[$key]["voc"]) / $duplicatesSvgs[$key]["voc"]) * 100;
                        }
                    }
                }
            }
        }
        return $dpr;
    }

    public function getDuplicatesSvgsAttribute()
    {
        $duplicatesSvgs = [];
        $svgs = $this->svgs;
        $duplicates = $this->duplicates;

        if (isset($this->values["samples"])) {
            foreach ($this->values["samples"] as $key => $sample) {
                if (isset($sample["results"])) {

                    if (isset(array_chunk($sample["results"], 3)[1])) {

                        $duplicatesSvgs[$key]["temperature"] = ($svgs[$key]["temperature"] + $duplicates[$key]["temperature"]) / 2;
                        $duplicatesSvgs[$key]["ph"] = ($svgs[$key]["ph"] + $duplicates[$key]["ph"]) / 2;
                        $duplicatesSvgs[$key]["orp"] = ($svgs[$key]["orp"] + $duplicates[$key]["orp"]) / 2;
                        $duplicatesSvgs[$key]["conductivity"] = ($svgs[$key]["conductivity"] + $duplicates[$key]["conductivity"]) / 2;
                        $duplicatesSvgs[$key]["salinity"] = ($svgs[$key]["salinity"] + $duplicates[$key]["salinity"]) / 2;
                        $duplicatesSvgs[$key]["psi"] = ($svgs[$key]["psi"] + $duplicates[$key]["psi"]) / 2;
                        $duplicatesSvgs[$key]["sat"] = ($svgs[$key]["sat"] + $duplicates[$key]["sat"]) / 2;
                        $duplicatesSvgs[$key]["conc"] = ($svgs[$key]["conc"] + $duplicates[$key]["conc"]) / 2;
                        $duplicatesSvgs[$key]["eh"] = ($svgs[$key]["eh"] + $duplicates[$key]["eh"]) / 2;
                        $duplicatesSvgs[$key]["ntu"] = ($svgs[$key]["ntu"] + $duplicates[$key]["ntu"]) / 2;
                        $duplicatesSvgs[$key]["chlorine"] = ($svgs[$key]["chlorine"] + $duplicates[$key]["chlorine"]) / 2;
                        $duplicatesSvgs[$key]["residualchlorine"] = ($svgs[$key]["residualchlorine"] + $duplicates[$key]["residualchlorine"]) / 2;
                        $duplicatesSvgs[$key]["voc"] = ($svgs[$key]["voc"] + $duplicates[$key]["voc"]) / 2;
                    }
                }
            }
        }
        return $duplicatesSvgs;
    }

    public function getDuplicatesAttribute()
    {
        $duplicates = [];

        if (isset($this->values["samples"])) {
            foreach ($this->values["samples"] as $key => $sample) {
                if (isset($sample["results"])) {
                    $sum = [];
                    $size = count(array_chunk($sample["results"], 3)[0]);

                    if (isset(array_chunk($sample["results"], 3)[1])) {
                        $sum["temperature"] = 0;
                        $sum["ph"] = 0;
                        $sum["orp"] = 0;
                        $sum["conductivity"] = 0;
                        $sum["salinity"] = 0;
                        $sum["psi"] = 0;
                        $sum["sat"] = 0;
                        $sum["conc"] = 0;
                        $sum["ntu"] = 0;
                        $sum["chlorine"] = 0;
                        $sum["residualchlorine"] = 0;
                        $sum["voc"] = 0;

                        foreach (array_chunk($sample["results"], 3)[1] as $value) {
                            if (isset($value["temperature"])) {
                                $sum["temperature"] += $value["temperature"];
                            }
                            if (isset($value["ph"])) {
                                $sum["ph"] += $value["ph"];
                            }
                            if (isset($value["orp"])) {
                                $sum["orp"] += $value["orp"];
                            }
                            if (isset($value["conductivity"])) {
                                $sum["conductivity"] += $value["conductivity"];
                            }
                            if (isset($value["salinity"])) {
                                $sum["salinity"] += $value["salinity"];
                            }
                            if (isset($value["psi"])) {
                                $sum["psi"] += $value["psi"];
                            }
                            if (isset($value["sat"])) {
                                $sum["sat"] += $value["sat"];
                            }
                            if (isset($value["conc"])) {
                                $sum["conc"] += $value["conc"];
                            }
                            if (isset($value["ntu"])) {
                                $sum["ntu"] += $value["ntu"];
                            }
                            if (isset($value["chlorine"])) {
                                $sum["chlorine"] += $value["chlorine"];
                            }
                            if (isset($value["residualchlorine"])) {
                                $sum["residualchlorine"] += $value["residualchlorine"];
                            }
                            if (isset($value["voc"])) {
                                $sum["voc"] += $value["voc"];
                            }
                        }

                        $duplicates[$key]["temperature"] = $sum["temperature"] / $size;
                        $duplicates[$key]["ph"] = $sum["ph"] / $size;
                        $duplicates[$key]["orp"] = $sum["orp"] / $size;
                        $duplicates[$key]["conductivity"] = $sum["conductivity"] / $size;
                        $duplicates[$key]["salinity"] = $sum["salinity"] / $size;
                        $duplicates[$key]["psi"] = $sum["psi"] / $size;
                        $duplicates[$key]["sat"] = $sum["sat"] / $size;
                        $duplicates[$key]["conc"] = $sum["conc"] / $size;
                        $duplicates[$key]["eh"] = $duplicates[$key]["orp"] + 199;
                        $duplicates[$key]["ntu"] = $sum["ntu"] / $size;
                        $duplicates[$key]["chlorine"] = $sum["chlorine"] / $size;
                        $duplicates[$key]["residualchlorine"] = $sum["residualchlorine"] / $size;
                        $duplicates[$key]["voc"] = $sum["voc"] / $size;
                    }
                }
            }
        }
        return $duplicates;
    }

    public function getSvgsAttribute()
    {
        $svgs = [];
        $sizeTemperature = 0;
        $sizePh = 0;
        $sizeOrp = 0;
        $sizeConductivity = 0;
        $sizeSalinity = 0;
        $sizePsi = 0;
        $sizeSat = 0;
        $sizeConc = 0;
        $sizeNtu = 0;
        $sizeChlorine = 0;
        $sizeResidualchlorine = 0;
        $sizeVoc = 0;

        if (isset($this->values["samples"])) {
            foreach ($this->values["samples"] as $key => $sample) {
                if (isset($sample["results"])) {
                    $sum = [];
                    $sizeTemperature = 0;
                    $sizePh = 0;
                    $sizeOrp = 0;
                    $sizeConductivity = 0;
                    $sizeSalinity = 0;
                    $sizePsi = 0;
                    $sizeSat = 0;
                    $sizeConc = 0;
                    $sizeNtu = 0;
                    $sizeChlorine = 0;
                    $sizeResidualchlorine = 0;
                    $sizeVoc = 0;

                    foreach(array_chunk($sample["results"], 3)[0] as $count) {
                        if(isset($count["temperature"])) $sizeTemperature++;
                        if(isset($count["ph"])) $sizePh++;
                        if(isset($count["orp"])) $sizeOrp++;
                        if(isset($count["conductivity"])) $sizeConductivity++;
                        if(isset($count["salinity"])) $sizeSalinity++;
                        if(isset($count["psi"])) $sizePsi++;
                        if(isset($count["sat"])) $sizeSat++;
                        if(isset($count["conc"])) $sizeConc++;
                        if(isset($count["chlorine"])) $sizeChlorine++;
                        if(isset($count["residualchlorine"])) $sizeResidualchlorine++;
                        if(isset($count["voc"])) $sizeVoc++;
                    }

                    $sum["temperature"] = 0;
                    $sum["ph"] = 0;
                    $sum["orp"] = 0;
                    $sum["conductivity"] = 0;
                    $sum["salinity"] = 0;
                    $sum["psi"] = 0;
                    $sum["sat"] = 0;
                    $sum["conc"] = 0;
                    $sum["ntu"] = 0;
                    $sum["chlorine"] = 0;
                    $sum["residualchlorine"] = 0;
                    $sum["voc"] = 0;

                    foreach (array_chunk($sample["results"], 3)[0] as $value) {
                        if (isset($value["temperature"])) {
                            $sum["temperature"] += $value["temperature"];
                        }
                        if (isset($value["ph"])) {
                            $sum["ph"] += $value["ph"];
                        }
                        if (isset($value["orp"])) {
                            $sum["orp"] += $value["orp"];
                        }
                        if (isset($value["conductivity"])) {
                            $sum["conductivity"] += $value["conductivity"];
                        }
                        if (isset($value["salinity"])) {
                            $sum["salinity"] += $value["salinity"];
                        }
                        if (isset($value["psi"])) {
                            $sum["psi"] += $value["psi"];
                        }
                        if (isset($value["sat"])) {
                            $sum["sat"] += $value["sat"];
                        }
                        if (isset($value["conc"])) {
                            $sum["conc"] += $value["conc"];
                        }
                        if (isset($value["ntu"])) {
                            $sum["ntu"] += $value["ntu"];
                        }
                        if (isset($value["chlorine"])) {
                            $sum["chlorine"] += $value["chlorine"];
                        }
                        if (isset($value["residualchlorine"])) {
                            $sum["residualchlorine"] += $value["residualchlorine"];
                        }
                        if (isset($value["voc"])) {
                            $sum["voc"] += $value["voc"];
                        }
                    }

                    $svgs[$key]["temperature"] = $sizeTemperature > 0 ? $sum["temperature"] / $sizeTemperature : null;
                    $svgs[$key]["ph"] = $sizePh > 0 ? $sum["ph"] / $sizePh : null;
                    $svgs[$key]["orp"] = $sizeOrp > 0 ? $sum["orp"] / $sizeOrp : null;
                    $svgs[$key]["conductivity"] = $sizeConductivity > 0 ? $sum["conductivity"] / $sizeConductivity : null;
                    $svgs[$key]["salinity"] = $sizeSalinity > 0 ? $sum["salinity"] / $sizeSalinity : null;
                    $svgs[$key]["psi"] = $sizePsi > 0 ? $sum["psi"] / $sizePsi : null;
                    $svgs[$key]["sat"] = $sizeSat > 0 ? $sum["sat"] / $sizeSat : null;
                    $svgs[$key]["conc"] = $sizeConc > 0 ? $sum["conc"] / $sizeConc : null;
                    $svgs[$key]["eh"] = $svgs[$key]["orp"] + 199;
                    $svgs[$key]["ntu"] = $sizeNtu > 0 ? $sum["ntu"] / $sizeNtu : 0;
                    $svgs[$key]["chlorine"] = $sizeChlorine > 0 ? $sum["chlorine"] / $sizeChlorine : 0;
                    $svgs[$key]["residualchlorine"] = $sizeResidualchlorine > 0 ? $sum["residualchlorine"] / $sizeResidualchlorine : 0;
                    $svgs[$key]["voc"] = $sizeVoc > 0 ? $sum["voc"] / $sizeVoc : 0;
                }
            }
        }

        return $svgs;
    }

    public function sortSamples($type = "point")
    {
        $values = $this->values;
        switch ($type) {
            case 'point':
                uasort($values["samples"], function ($a, $b) {
                    return strnatcmp($a["point"], $b["point"]);
                });
                break;

            case 'collect':
                uasort($values["samples"], function ($a, $b) {
                    $firstDate = Carbon::parse($a['collect']);
                    $secondDate = Carbon::parse($b['collect']);
                    return (!$firstDate->gt($secondDate)) ? -1 : 1;
                });
                break;
        }
        return $values["samples"];
    }

    public function sortCoordinates()
    {
        $values = $this->values;
        $coordinates = $values['coordinates'];
        if(is_array($coordinates)) asort($coordinates);
        return $coordinates;
    }
}
