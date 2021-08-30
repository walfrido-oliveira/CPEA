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
            $projects->orderBy($query['order_by'], $ascending);

        }

        return $projects->paginate($perPage, ['*'], 'campaigns');
    }
}
