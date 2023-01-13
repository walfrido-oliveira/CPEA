<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'values', 'form_id'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'values' => 'array',
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

        $envionmentalAreas = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['form_id']))
            {
                if(!is_null($query['form_id']))
                {
                    $q->where('form_id', $query['form_id']);
                }
            }

            if(isset($query['project_id']))
            {
                if(!is_null($query['project_id']))
                {
                    $q->where('values', 'like', '%' . $query['project_id'] . '%');
                }
            }

        });

        $envionmentalAreas->orderBy($orderBy, $ascending);

        return $envionmentalAreas->paginate($perPage);
    }

    /** Get SGVs sample Array
     *
     * @return array
     */
    public function getSvgs()
    {
        $svgs = [];

        foreach ($this->values["samples"] as $key => $sample) {
          if (isset($sample["results"])) {
            $sum = [];
            $size = count(array_chunk($sample["results"], 3)[0]);

            $sum["temperature"] = 0;
            $sum["ph"] = 0;
            $sum["orp"] = 0;
            $sum["conductivity"] = 0;
            $sum["salinity"] = 0;
            $sum["psi"] = 0;
            $sum["sat"] = 0;
            $sum["conc"] = 0;
            $sum["ntu"] = 0;

            foreach (array_chunk($sample["results"], 3)[0] as $key2 => $value ) {
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
            }

            $svgs[$key]["temperature"] = $sum["temperature"] / $size;
            $svgs[$key]["ph"] = $sum["ph"] / $size;
            $svgs[$key]["orp"] = $sum["orp"] / $size;
            $svgs[$key]["conductivity"] = $sum["conductivity"] / $size;
            $svgs[$key]["salinity"] = $sum["salinity"] / $size;
            $svgs[$key]["psi"] = $sum["psi"] / $size;
            $svgs[$key]["sat"] = $sum["sat"] / $size;
            $svgs[$key]["conc"] = $sum["conc"] / $size;
            $svgs[$key]["eh"] = $svgs[$key]["orp"] + 199;
            $svgs[$key]["ntu"] = $sum["ntu"] / $size;
          }
        }
        return $svgs;
    }

}
