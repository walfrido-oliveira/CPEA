<?php

namespace App\Models;

use App\Models\Campaign;
use App\Models\Customer;
use App\Models\ProjectPointMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_cod', 'customer_id',
    ];

    /**
     * The Customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The ProjectPointMatrix.
     */
    public function projectPointMatrices()
    {
        return $this->HasMany(ProjectPointMatrix::class);
    }

    /**
     * The Campaign.
     */
    public function campaigns()
    {
        return $this->HasMany(Campaign::class);
    }

    public function getPointMatricesCustomFields()
    {
        return $this->ProjectPointMatrices
        ->map(function($item) {
            return [
                'id' => $item->id,
                'custom_name' => $item->custom_name
            ];
        })
        ->pluck('custom_name', 'id')
        ->all();
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
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

        $projects = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['project_cod']))
            {
                if(!is_null($query['project_cod']))
                {
                    $q->where('project_cod', 'like','%' . $query['project_cod'] . '%');
                }
            }

            if(isset($query['customer_id']))
            {
                if(!is_null($query['customer_id']))
                {
                    $q->where('customer_id', $query['customer_id']);
                }
            }
        });

        if($orderBy == 'campaigns.name' )
        {
            $projects->with('campaigns')
            ->leftJoin('campaigns', 'campaigns.project_id', '=', 'projects.id')
            ->select('projects.*')
            ->orderBy($orderBy, $ascending);
        }
        else
        {
            $projects->orderBy($orderBy, $ascending);
        }
        //dd($projects->get());
        return $projects->paginate($perPage);
    }
}
