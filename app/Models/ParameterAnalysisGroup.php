<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterAnalysisGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parameter_analysis_group_id','name', 'order', 'final_validity'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'final_validity' => 'datetime'
    ];

    /**
     * Get parent
     */
    public function parameterAnalysisGroup()
    {
        return $this->belongsTo(ParameterAnalysisGroup::class);
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

        $users = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['name']))
            {
                if(!is_null($query['name']))
                {
                    $q->where('name', 'like','%' . $query['name'] . '%');
                }
            }

            if(isset($query['parameter_analysis_group_id']))
            {
                if(!is_null($query['parameter_analysis_group_id']))
                {
                    $q->where('parameter_analysis_group_id', $query['parameter_analysis_group_id']);
                }
            }
        });

        if(!isset($query['order_by']))
        {
            $users->orderBy('created_at', 'desc');
        }
        else
        {
            $users->orderBy($query['order_by'], $ascending);
        }

        return $users->paginate($perPage);
    }
}
