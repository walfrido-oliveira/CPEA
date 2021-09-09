<?php

namespace App\Models;

use App\Models\Project;
use App\Models\CampaignStatus;
use App\Models\ProjectPointMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_point_matrix_id', 'campaign_status_id', 'name', 'date_collection', 'project_id',
        'tide', 'environmental_conditions', 'sample_depth', 'environmental_regime', 'floating_materials',
        'effluent_type', 'report_identification', 'organism_type', 'popular_name', 'identification_pm',
        'sample_horizon', 'refq', 'utm', 'water_depth', 'sedimentary_layer', 'secchi_record', 'total_depth',
        'sampling_area', 'pm_depth', 'pm_diameter', 'water_level', 'oil_level', 'field_measurements',
        'temperature', 'humidity', 'pressure'
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
     * The project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The ProjectPointMatrix.
     */
    public function projectPointMatrix()
    {
        return $this->belongsTo(ProjectPointMatrix::class);
    }

    /**
     * The CampaignStatus.
     */
    public function campaignStatus()
    {
        return $this->belongsTo(CampaignStatus::class);
    }

    /**
     * Find in dabase
     *
     * @param Array $query
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

        $campaigns = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['project_id'])) $q->where('campaigns.project_id', $query['project_id']);

            if(isset($query['name']))
            {
                if(!is_null($query['name']))
                {
                    $q->where('name', 'like','%' . $query['name'] . '%');
                }
            }
        });

        if($orderBy == 'identification' || $orderBy == 'area')
        {
            $campaigns
            ->with('projectPointMatrix.pointIdentification')
            ->leftJoin('project_point_matrices', 'project_point_matrices.id', '=', 'campaigns.project_point_matrix_id')
            ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
            ->orderBy($orderBy, $ascending);
        }else if($orderBy == 'projects.project_cod')
        {
            $campaigns
            ->with('project')
            ->leftJoin('projects', 'projects.id', '=', 'campaigns.project_id')
            ->select('campaigns.*')
            ->orderBy($orderBy, $ascending);
        }

        else {
            $campaigns->orderBy($orderBy, $ascending);
        }

        return $campaigns->paginate($perPage, ['*'], 'campaigns');
    }
}
