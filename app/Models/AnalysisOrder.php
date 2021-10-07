<?php

namespace App\Models;

use App\Models\Lab;
use App\Models\Campaign;
use App\Models\ParameterAnalysis;
use App\Models\ProjectPointMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnalysisOrder extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_id', 'lab_id', 'status', 'obs', 'analyzing_at', 'concluded_at'
    ];

    /**
     * Get formatted id
     */
    public function getFormattedIdAttribute()
    {
        return \str_pad((string) $this->id, 8, "0", STR_PAD_LEFT) . '-' . $this->created_at->format('Y');
    }

    /**
     * The campaign
     *
     * @return string
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * The lab
     */
    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    /**
     * The projectPointMatrix
     */
    public function projectPointMatrices()
    {
        return $this->belongsToMany(ProjectPointMatrix::class);
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

        $labs = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['campaign_id']))
            {
                if(!is_null($query['campaign_id']))
                {
                    $q->where('campaign_id', $query['campaign_id']);
                }
            }

            if(isset($query['lab_id']))
            {
                if(!is_null($query['lab_id']))
                {
                    $q->where('lab_id', $query['lab_id']);
                }
            }
        });

        $labs->orderBy($orderBy, $ascending);

        return $labs->paginate($perPage);
    }
}
