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
}
