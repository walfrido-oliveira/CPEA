<?php

namespace App\Models;

use App\Models\Unity;
use App\Models\AnalysisMatrix;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use Illuminate\Database\Eloquent\Model;
use App\Models\GuidingParameterRefValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuidingParameterValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guiding_parameter_id', 'analysis_matrix_id', 'parameter_analysis_id',
        'guiding_parameter_ref_value_id', 'guiding_value_id', 'unity_legislation_id',
        'unity_analysis_id', 'guiding_legislation_value', 'guiding_legislation_value_1', 'guiding_legislation_value_2',
        'guiding_analysis_value', 'guiding_analysis_value_1', 'guiding_analysis_value_2'
    ];

    /**
     * The guiding parameter
     */
    public function guidingParameter()
    {
        return $this->belongsTo(GuidingParameter::class);
    }

    /**
     * The analysis matrix
     */
    public function analysisMatrix()
    {
        return $this->belongsTo(AnalysisMatrix::class);
    }

    /**
     * The parameter analysis
     */
    public function parameterAnalysis()
    {
        return $this->belongsTo(ParameterAnalysis::class);
    }

    /**
     * The guiding parameter ref value
     */
    public function guidingParameterRefValue()
    {
        return $this->belongsTo(GuidingParameterRefValue::class);
    }

    /**
     * The guiding value
     */
    public function guidingValue()
    {
        return $this->belongsTo(GuidingValue::class);
    }

    /**
     * The unity legislation
     */
    public function unityLegislation()
    {
        return $this->belongsTo(Unity::class, 'unity_legislation_id', 'id');
    }

    /**
     * The unity analysis
     */
    public function unityAnalysis()
    {
        return $this->belongsTo(Unity::class, 'unity_analysis_id', 'id');
    }

    /**
     * Find guiding parameter value in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : 5;
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';

        $guidingParameterValues = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['guiding_parameter_id']))
            {
                if(!is_null($query['guiding_parameter_id']))
                {
                    $q->where('guiding_parameter_id', $query['guiding_parameter_id']);
                }
            }

            if(isset($query['analysis_matrix_id']))
            {
                if(!is_null($query['analysis_matrix_id']))
                {
                    $q->where('analysis_matrix_id', $query['analysis_matrix_id']);
                }
            }

            if(isset($query['parameter_analysis_id']))
            {
                if(!is_null($query['parameter_analysis_id']))
                {
                    $q->where('parameter_analysis_id', $query['parameter_analysis_id']);
                }
            }
        });

        if(!isset($query['order_by']))
        {
            $guidingParameterValues->orderBy('created_at', 'desc');
        }
        else
        {
            $guidingParameterValues->orderBy($query['order_by'], $ascending);
        }

        return $guidingParameterValues->paginate($perPage);
    }
}
