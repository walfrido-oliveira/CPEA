<?php

namespace App\Models;

use App\Models\Project;
use App\Models\AnalysisMatrix;
use App\Models\PlanActionLevel;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\PointIdentification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectPointMatrix extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'point_identification_id', 'analysis_matrix_id', 'plan_action_level_id',
        'guiding_parameter_id', 'parameter_analysis_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'custom_name',
    ];

    /**
     * The Project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The Point Identification.
     */
    public function pointIdentification()
    {
        return $this->belongsTo(PointIdentification::class);
    }

    /**
     * The Analysis Matrix.
     */
    public function analysisMatrix()
    {
        return $this->belongsTo(AnalysisMatrix::class);
    }

    /**
     * The Plan Action Level.
     */
    public function planActionLevel()
    {
        return $this->belongsTo(PlanActionLevel::class);
    }

    /**
     * The Guiding Parameter.
     */
    public function guidingParameter()
    {
        return $this->belongsTo(GuidingParameter::class);
    }

    /**
     * The Parameter Analysis.
     */
    public function parameterAnalysis()
    {
        return $this->belongsTo(ParameterAnalysis::class);
    }

    public function getCustomNameAttribute()
    {
        $result = '';
        if($this->pointIdentification)
        {
            $result = $this->pointIdentification->area . ' - ' . $this->pointIdentification->identification;
        }
        if ($this->analysisMatrix)
        {
            $result .= ' - ' . $this->analysisMatrix->name;
        }
        return $result;
    }

     /**
     * Find projects in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : 5;
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';

        $projects = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }
        });

        if(!isset($query['order_by']))
        {

            $projects->orderBy('created_at', $ascending);

        }
        else
        {
            if($query['order_by'] == 'identification' || $query['order_by'] == 'area')
            {
                $projects
                ->with('pointIdentification')
                ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
                ->orderBy($query['order_by'], $ascending);
            }
            else
            {
                $projects->orderBy($query['order_by'], $ascending);
            }

        }

        return $projects->paginate($perPage, ['*'], 'project-point-matrices');
    }
}
