<?php

namespace App\Models;

use App\Models\Lab;
use App\Models\Project;
use App\Models\AnalysisOrder;
use App\Models\AnalysisResult;
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
    public function projectPointMatrices()
    {
        return $this->hasMany(ProjectPointMatrix::class);
    }

    /**
     * The AnalysisOrder.
     */
    public function analysisOrders()
    {
        return $this->hasMany(AnalysisOrder::class);
    }

    public function labs()
    {
        return $this->hasManyThrough(Lab::class, AnalysisOrder::class, 'campaign_id', 'id', 'id', 'lab_id');
    }

    public function analysisResults()
    {
        return $this->hasManyThrough(AnalysisResult::class, AnalysisOrder::class);
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

            if(isset($query['project_cod']))
            {
                if(!is_null($query['project_cod']))
                {
                    $q->whereHas('project', function($q) use($query) {
                        $q->where('project_cod', 'like','%' . $query['project_cod'] . '%');
                    });
                }
            }

            if(isset($query['lab_id']))
            {
                if(!is_null($query['lab_id']))
                {
                    $q->whereHas('analysisOrders', function($q) use($query) {
                        $q->where('lab_id',  $query['lab_id']);
                    });
                }
            }

            if(isset($query['status']))
            {
                if(!is_null($query['status']))
                {
                    $q->whereHas('project', function($q) use($query) {
                        $q->where('status', $query['status']);
                    });
                }
            }

            if(isset($query['customer_id']))
            {
                if(!is_null($query['customer_id']))
                {
                    $q->whereHas('project', function($q) use($query) {
                        $q->where('customer_id', $query['customer_id']);
                    });
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
        }
        else if($orderBy == 'projects.project_cod' ||
                $orderBy == 'projects.status' ||
                $orderBy == 'projects.customer_id')
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
