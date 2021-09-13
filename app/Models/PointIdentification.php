<?php

namespace App\Models;

use App\Models\Campaign;
use App\Models\Customer;
use App\Models\ProjectPointMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
     * The GeodeticSystem.
     */
    public function geodeticSystem()
    {
        return $this->belongsTo(GeodeticSystem::class);
    }

    /**
     * Get Customer array
     *
     * @return array
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }

    /**
     * Get ProjectPointMatrix array
     *
     * @return array
     */
    public function projectPointMatrices()
    {
        return $this->HasMany(ProjectPointMatrix::class);
    }

    /**
     * The Campaign .
     */
    public function campaigns()
    {
        return $this->hasManyThrough(Campaign::class, ProjectPointMatrix::class, 'id', 'id', 'project_point_matrix_id', 'campaign_id');
    }

    /**
     * Find point idetification in dabase
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

        $pointIdentifications->orderBy($orderBy, $ascending);

        return $pointIdentifications->paginate($perPage);
    }
}
