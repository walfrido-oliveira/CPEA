<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\EnvironmentalArea;
use App\Models\EnvironmentalAgency;
use App\Models\GuidingParameterValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuidingParameter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'environmental_area_id', 'environmental_agency_id', 'customer_id',
        'environmental_guiding_parameter_id', 'name', 'resolutions',
        'articles', 'observation'
    ];

    /**
     * The customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The EnvironmentalArea
     */
    public function environmentalArea()
    {
        return $this->belongsTo(EnvironmentalArea::class);
    }

    /**
     * The environmentalAgency
     */
    public function environmentalAgency()
    {
        return $this->belongsTo(EnvironmentalAgency::class);
    }

    /**
     * The Guiding Parameter Value
     */
    public function guidingParameterValues()
    {
        return $this->hasMany(GuidingParameterValue::class);
    }

    /**
     * Find guidingParameters in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : 5;
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';

        $guidingParameters = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['environmental_guiding_parameter_id']))
            {
                if(!is_null($query['environmental_guiding_parameter_id']))
                {
                    $q->where('environmental_guiding_parameter_id', 'like', '%' .  $query['environmental_guiding_parameter_id'] . '%');
                }
            }

            if(isset($query['environmental_agency_id']))
            {
                if(!is_null($query['environmental_agency_id']))
                {
                    $q->where('environmental_agency_id', $query['environmental_agency_id']);
                }
            }

            if(isset($query['name']))
            {
                if(!is_null($query['name']))
                {
                    $q->where('name', 'like','%' . $query['name'] . '%');
                }
            }
        });

        if(!isset($query['order_by']))
        {
            $guidingParameters->orderBy('created_at', 'desc');
        }
        else
        {
            $guidingParameters->orderBy($query['order_by'], $ascending);
        }

        return $guidingParameters->paginate($perPage);
    }
}
