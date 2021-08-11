<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisMatrix extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'analysis_matrix_id', 'name'
    ];

    /**
     * Find analysisMatrix in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : 5;
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';

        $analysisMatrix = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['analysis_matrix_id']))
            {
                if(!is_null($query['analysis_matrix_id']))
                {
                    $q->where('analysis_matrix_id', 'like','%' . $query['analysis_matrix_id'] . '%');
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
            $analysisMatrix->orderBy('created_at', 'desc');
        }
        else
        {
            $analysisMatrix->orderBy($query['order_by'], $ascending);
        }

        return $analysisMatrix->paginate($perPage);
    }
}
