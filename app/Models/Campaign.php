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
     * @param string $project_id
     *
     * @return array
     */
    public static function filter($query, $project_id)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : 5;
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';

        $projects = self::where(function($q) use ($query, $project_id) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            $q->where('campaigns.project_id', $project_id);

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
            $projects->orderBy('created_at', $ascending);
        }
        else
        {
            if($query['order_by'] == 'identification' || $query['order_by'] == 'area')
            {
                $projects
                ->with( 'projectPointMatrix.pointIdentification')
                ->leftJoin('project_point_matrices', 'project_point_matrices.id', '=', 'campaigns.project_point_matrix_id')
                ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
                ->orderBy($query['order_by'], $ascending);
            } else {
                $projects->orderBy($query['order_by'], $ascending);
            }

        }

        return $projects->paginate($perPage, ['*'], 'project-campaigns');
    }
}
