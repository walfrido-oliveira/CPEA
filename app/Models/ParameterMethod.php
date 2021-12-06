<?php

namespace App\Models;

use App\Models\AnalysisMatrix;
use App\Models\AnalysisMethod;
use App\Models\ParameterAnalysis;
use App\Models\PreparationMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParameterMethod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'analysis_matrix_id',  'parameter_analysis_id', 'preparation_method_id',
        'analysis_method_id', 'validate_preparation', 'time_preparation', 'time_analysis'
    ];

    /**
     * The Parameter Analysis.
     */
    public function parameterAnalysis()
    {
        return $this->belongsTo(ParameterAnalysis::class);
    }

     /**
     * The Analysis Matrix.
     */
    public function parameterMethod()
    {
        return $this->belongsTo(AnalysisMatrix::class);
    }

     /**
     * The PeparationMethod.
     */
    public function preparationMethod()
    {
        return $this->belongsTo(PreparationMethod::class);
    }

     /**
     * The AnalysisMethod.
     */
    public function analysisMethod()
    {
        return $this->belongsTo(AnalysisMethod::class);
    }

    /**
     * Find parameterMethod in dabase
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

        $parameterMethod = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }
        });

        $parameterMethod->orderBy($orderBy, $ascending);

        return $parameterMethod->paginate($perPage);
    }
}
