<?php

namespace App\Models;

use App\Models\ParameterAnalysis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalculationParameter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parameter_analysis_id', 'formula'
    ];

    /**
     * The parameter Analysis
     */
    public function parameterAnalysis()
    {
        return $this->belongsTo(ParameterAnalysis::class);
    }

    /**
     * Find unity in dabase
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

        $unities = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
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

        $unities->orderBy($orderBy, $ascending);

        return $unities->paginate($perPage);
    }
}
