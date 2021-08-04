<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointIdentification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'geodetic_system_id',
        'area', 'identification',
        'utm_me_coordinate', 'utm_mm_coordinate',
        'pool_depth', 'pool_diameter', 'pool_volume',
        'water_depth', 'water_collection_depth',
        'sedimentary_collection_depth', 'collection_depth'
    ];



    /**
     * The roles that belong to the geodetic system.
     */
    public function geodeticSystem()
    {
        return $this->belongsTo(GeodeticSystem::class);
    }

    /**
     * Find users in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : 5;
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';

        $pointIdentifications = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['area']))
            {
                if(!is_null($query['area']))
                {
                    $q->where('area', 'like','%' . $query['area'] . '%');
                }
            }

            if(isset($query['identification']))
            {
                if(!is_null($query['identification']))
                {
                    $q->where('identification', 'like','%' . $query['identification'] . '%');
                }
            }
        });

        if(!isset($query['order_by']))
        {
            $pointIdentifications->orderBy('created_at', 'desc');
        }
        else
        {
            $pointIdentifications->orderBy($query['order_by'], $ascending);
        }

        return $pointIdentifications->paginate($perPage);
    }
}
