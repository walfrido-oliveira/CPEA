<?php

namespace App\Models;

use App\Models\AnalysisParameter;
use App\Models\CalculationParameter;
use App\Models\ParameterAnalysisGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParameterAnalysis extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'analysis_parameter_id', 'parameter_analysis_group_id',
        'cas_rn', 'ref_cas_rn', 'analysis_parameter_name', 'order',
        'decimal_place', 'final_validity'
    ];

    protected $appends = ['grupo_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'final_validity' => 'datetime',
        'decimal_place' => 'double',
        'order' => 'integer'
    ];

    /**
     * @return string
     */
    public function getGrupoNameAttribute()
    {
        if($this->parameterAnalysisGroup) return $this->parameterAnalysisGroup->name;
        return '';
    }

    /**
     * Get analysis parameter
     */
    public function analysisParameter()
    {
        return $this->belongsTo(AnalysisParameter::class);
    }

    /**
     * Get analysis parameter group
     */
    public function parameterAnalysisGroup()
    {
        return $this->belongsTo(ParameterAnalysisGroup::class);
    }

    /**
     * The calculationParameters
     */
    public function calculationParameter()
    {
        return $this->belongsTo(CalculationParameter::class);
    }

    /**
     * Get full name Parameter Nalysis
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->analysis_parameter_name . '-' . $this->cas_rn . ($this->parameterAnalysisGroup ? '-' . $this->parameterAnalysisGroup->name : '');
    }

    /**
     * Get calc name
     *
     * @return string
     */
    public function getCalcNameAttribute()
    {
        return '{' . $this->analysis_parameter_name . '&' . $this->cas_rn . ($this->parameterAnalysisGroup ? '&' . $this->parameterAnalysisGroup->name : '') . '}';
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
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

        $parameterAnalyses = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['q']))
            {
                if(!is_null($query['q']))
                {
                    $q->where('analysis_parameter_name', 'like','%' . $query['q'] . '%');
                }
            }

            if(isset($query['analysis_parameter_id']))
            {
                if(!is_null($query['analysis_parameter_id']))
                {
                    $q->where('analysis_parameter_id', $query['analysis_parameter_id']);
                }
            }

            if(isset($query['parameter_analysis_group_id']))
            {
                if(!is_null($query['parameter_analysis_group_id']))
                {
                    $q->where('parameter_analysis_group_id', $query['parameter_analysis_group_id']);
                }
            }

            if(isset($query['analysis_parameter_name']))
            {
                if(!is_null($query['analysis_parameter_name']))
                {
                    $q->where('analysis_parameter_name', 'like','%' . $query['analysis_parameter_name'] . '%');
                }
            }

            if(isset($query['cas_rn']))
            {
                if(!is_null($query['cas_rn']))
                {
                    $q->where('cas_rn', 'like','%' . $query['cas_rn'] . '%');
                }
            }
        });

        $parameterAnalyses->orderBy($orderBy, $ascending);

        return $parameterAnalyses->paginate($perPage);
    }
}
