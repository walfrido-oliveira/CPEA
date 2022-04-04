<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\AnalysisOrder;
use App\Models\AnalysisMatrix;
use App\Models\AnalysisResult;
use App\Models\ParameterMethod;
use App\Models\PlanActionLevel;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\PreparationMethod;
use App\Models\PointIdentification;
use App\Models\CalculationParameter;
use Illuminate\Support\Facades\Cache;
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
        'project_id', 'point_identification_id', 'analysis_matrix_id', 'parameter_method_preparation_id', 'parameter_method_analysis_id',
        'parameter_analysis_id', 'tide', 'environmental_conditions',
        'sample_depth', 'environmental_regime', 'floating_materials',
        'effluent_type', 'report_identification', 'organism_type', 'popular_name', 'identification_pm',
        'sample_horizon', 'refq', 'utm', 'water_depth', 'sedimentary_layer', 'secchi_record', 'total_depth',
        'sampling_area', 'pm_depth', 'pm_diameter', 'water_level', 'oil_level', 'field_measurements',
        'temperature', 'humidity', 'pressure', 'campaign_id', 'date_collection'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_collection' => 'datetime'
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
     * The preparationMethod.
     */
    public function parameterMethodPreparation()
    {
        return $this->belongsTo(ParameterMethod::class, 'parameter_method_preparation_id');
    }

    /**
     * The analysisMethod.
     */
    public function parameterMethodAnalysis()
    {
        return $this->belongsTo(ParameterMethod::class, 'parameter_method_analysis_id');
    }

    /**
     * The campaign.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

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
     * The Guiding Parameter.
     */
    public function guidingParameters()
    {
        return $this->belongsToMany(GuidingParameter::class);
    }

    /**
     * The Parameter Analysis.
     */
    public function parameterAnalysis()
    {
        return $this->belongsTo(ParameterAnalysis::class);
    }

    public function calculationParameters()
    {
        return $this->hasManyThrough(CalculationParameter::class, ParameterAnalysis::class, 'id', 'parameter_analysis_id', 'parameter_analysis_id', 'id');
    }

    /**
     * The Analysis Result
     */
    public function analysisResult()
    {
        return $this->hasMany(AnalysisResult::class);
    }

    /**
     * @param int $id
     * @return AnalysisResult
     */
    public function getAnalysisResultById($id)
    {
       return $this->analysisResult()->where('analysis_order_id', $id)->first();
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
     * The AnalysisOrder
     */
    public function analysisOrders()
    {
        return $this->belongsToMany(AnalysisOrder::class);
    }

    /**
     * @param int $id
     * @return AnalysisOrder
     */
    public function getAnalysisOrderById($id)
    {
       return $this->analysisOrders()->where('analysis_order_id', $id)->first();
    }

    /**
     * Get status Lab
     *
     * @param int $id
     * @return string
     */
    public function getStatusLab($id)
    {
        $result = $this->analysisOrders()
        ->where('status', '!=', 'canceled')
        ->first();

        if($result == 'concluded' && count($this->analysisResult) == 0)
            return null;
        return $result ? $result->status : null;
    }

     /**
     * Find in dabase
     *
     * @param Array $query
     * @param string $project_id
     *
     * @return object
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;
        $page = isset($query['page']) ? $query['page'] : 1;

        $projects = $projects = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['campaign_name']))
            {
                if(!is_null($query['campaign_name']))
                {
                    $q->whereHas('campaign', function($q) use ($query) {
                        $q->where('name', 'like', '%' . $query['campaign_name'] . '%');
                    });
                }
            }

            if(isset($query['area']))
            {
                if(!is_null($query['area']))
                {
                    $q->whereHas('pointIdentification', function($q) use($query) {
                        $q->where('point_identifications.area', 'like', '%' . $query['area'] . '%')
                        ->orWhere('point_identifications.identification', 'like', '%' . $query['area'] . '%');
                    });
                }
            }

            if(isset($query['identification']))
            {
                if(!is_null($query['identification']))
                {
                    $q->whereHas('pointIdentification', function($q) use($query) {
                        $q->where('point_identifications.identification', 'like', '%' . $query['identification'] . '%');
                    });
                }
            }

            if(isset($query['parameter_analysis_group_name']))
            {
                if(!is_null($query['parameter_analysis_group_name']))
                {
                    $q->whereHas('parameterAnalysis', function($q) use($query) {
                        $q->whereHas('parameterAnalysisGroup', function($q) use($query) {
                            $q->where('parameter_analysis_groups.name', 'like', '%' .$query['parameter_analysis_group_name'] . '%' );
                        });
                    });
                }
            }

            if(isset($query['analysis_matrices_name']))
            {
                if(!is_null($query['analysis_matrices_name']))
                {
                    $q->whereHas('analysisMatrix', function($q) use($query) {
                        $q->where('analysis_matrices.name', 'like', '%' . $query['analysis_matrices_name'] . '%');
                    });
                }
            }

            if(isset($query['parameter_analysis_name']))
            {
                if(!is_null($query['parameter_analysis_name']))
                {
                    $q->whereHas('parameterAnalysis', function($q) use($query) {
                        $q->where('parameter_analyses.analysis_parameter_name', 'like', '%' . $query['parameter_analysis_name'] . '%');
                    });
                }
            }

            if(isset($query['guiding_parameter_name']))
            {
                if(!is_null($query['guiding_parameter_name']))
                {
                    $q->whereHas('guidingParameters', function($q) use($query) {
                        $q->where('guiding_parameters.name', 'like', '%' . $query['guiding_parameter_name'] . '%');
                    });
                }
            }

            if(isset($query['q']))
            {
                if(!is_null($query['q']))
                {
                    $q->where( function($q) use($query){
                        $q->whereHas('pointIdentification', function($q) use($query) {
                            $q->where('point_identifications.area', 'like', '%' . $query['q'] . '%')
                                ->orWhere('point_identifications.identification', 'like', '%' . $query['q'] . '%');
                        })
                        ->orWhereHas('analysisMatrix', function($q) use($query) {
                            $q->where('analysis_matrices.name', 'like', '%' . $query['q'] . '%');
                        })
                        ->orWhereHas('guidingParameters', function($q) use($query) {
                            $q->where('guiding_parameters.environmental_guiding_parameter_id', 'like', '%' . $query['q'] . '%');
                        })
                        ->orWhereHas('parameterAnalysis', function($q) use($query) {
                            $q->where('parameter_analyses.analysis_parameter_name', 'like', '%' . $query['q'] . '%');
                        });
                    });

                }
            }

            if(isset($query['project_id'])) $q->where('project_id', $query['project_id']);
        });

        if($orderBy == 'point_identifications.identification' ||
           $orderBy == 'point_identifications.area' ||
           $orderBy == 'guiding_parameter_project_point_matrix.guiding_parameter_id')
        {
            $projects
            ->with('pointIdentification')
            ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
            ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
            ->leftJoin('parameter_analysis_groups', 'parameter_analysis_groups.id', '=', 'parameter_analyses.parameter_analysis_group_id')
            ->leftJoin('guiding_parameter_project_point_matrix', 'guiding_parameter_project_point_matrix.project_point_matrix_id', '=', 'project_point_matrices.id')
            ->orderBy($orderBy, $ascending)
            ->orderBy('parameter_analysis_groups.name', 'asc')
            ->select('project_point_matrices.*')
            ->get();
        }
        else
        {
            $projects->orderBy($orderBy, $ascending);
        }

        if(isset($query['no-paginate']))
            $projects = $projects->get();
        else
            $projects = $projects->paginate($perPage, ['*'], 'project-point-matrices', $page > (int) ceil($projects->count() / $perPage) ? 1 : $page);

        return $projects;
    }

    /**
     * Find in dabase
     *
     * @param Array $query
     * @param string $project_id
     *
     * @return object
     */
    public static function simpleFilter($query)
    {
        $projects = $projects = self::where(function($q) use ($query) {

            if(isset($query['campaign_name']))
            {
                if(!is_null($query['campaign_name']))
                {
                    $q->whereHas('campaign', function($q) use ($query) {
                        $q->where('name', 'like', '%' . $query['campaign_name'] . '%');
                    });
                }
            }

            if(isset($query['area']))
            {
                if(!is_null($query['area']))
                {
                    $q->whereHas('pointIdentification', function($q) use($query) {
                        $q->where('point_identifications.area', 'like', '%' . $query['area'] . '%')
                        ->orWhere('point_identifications.identification', 'like', '%' . $query['area'] . '%');
                    });
                }
            }

            if(isset($query['identification']))
            {
                if(!is_null($query['identification']))
                {
                    $q->whereHas('pointIdentification', function($q) use($query) {
                        $q->where('point_identifications.identification', 'like', '%' . $query['identification'] . '%');
                    });
                }
            }

            if(isset($query['parameter_analysis_group_name']))
            {
                if(!is_null($query['parameter_analysis_group_name']))
                {
                    $q->whereHas('parameterAnalysis', function($q) use($query) {
                        $q->whereHas('parameterAnalysisGroup', function($q) use($query) {
                            $q->where('parameter_analysis_groups.name', 'like', '%' .$query['parameter_analysis_group_name'] . '%' );
                        });
                    });
                }
            }

            if(isset($query['analysis_matrices_name']))
            {
                if(!is_null($query['analysis_matrices_name']))
                {
                    $q->whereHas('analysisMatrix', function($q) use($query) {
                        $q->where('analysis_matrices.name', 'like', '%' . $query['analysis_matrices_name'] . '%');
                    });
                }
            }

            if(isset($query['parameter_analysis_name']))
            {
                if(!is_null($query['parameter_analysis_name']))
                {
                    $q->whereHas('parameterAnalysis', function($q) use($query) {
                        $q->where('parameter_analyses.analysis_parameter_name', 'like', '%' . $query['parameter_analysis_name'] . '%');
                    });
                }
            }

            if(isset($query['guiding_parameter_name']))
            {
                if(!is_null($query['guiding_parameter_name']))
                {
                    $q->whereHas('guidingParameters', function($q) use($query) {
                        $q->where('guiding_parameters.name', 'like', '%' . $query['guiding_parameter_name'] . '%');
                    });
                }
            }
        });


        return $projects->get();
    }
}
