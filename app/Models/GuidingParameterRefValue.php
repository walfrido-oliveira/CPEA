<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuidingParameterRefValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guiding_parameter_ref_value_id',
        'observation',
    ];

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

            if(isset($query['guiding_parameter_ref_value_id']))
            {
                if(!is_null($query['guiding_parameter_ref_value_id']))
                {
                    $q->where('guiding_parameter_ref_value_id', 'like','%' . $query['guiding_parameter_ref_value_id'] . '%');
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
