<?php

namespace App\Models;

use App\Models\Campaign;
use App\Models\Customer;
use App\Models\ProjectPointMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_cod', 'customer_id', 'guiding_parameter_order', 'status', 'colors'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'colors' => 'array',
        'guiding_parameter_order' => 'array',
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

            if(isset($query['campaign']))
            {
                if(!is_null($query['campaign']))
                {
                    $q->whereHas('campaigns', function($q) use($query) {
                        $q->where('campaigns.name', 'like', '%' . $query['campaign'] . '%');
                    });
                }
            }

            if(isset($query['lab']))
            {
                if(!is_null($query['lab']))
                {
                    #$q->where('project_cod', 'like','%' . $query['project_cod'] . '%');
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

        if($orderBy == 'campaigns.name' || $orderBy == 'campaigns.campaign_status_id' ||
           $orderBy == 'campaigns.updated_at' || $orderBy == 'campaigns.created_at')
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

        return $projects->paginate($perPage);
    }

    /**
     * @return Array
     */
    function getOrder()
    {
        $guidingParameters = collect([]);

        $ids = !is_array($this->guiding_parameter_order) ? explode(",", $this->guiding_parameter_order) : $this->guiding_parameter_order;
        $colors = !is_array($this->colors) ? explode(",", $this->colors) : $this->colors;
        $defaultColors = ["#ffcc99", "#ffff99", "#daeef3"];

        for ($i=0; $i < count($defaultColors); $i++)
        {
            if(!isset($colors[$i]))
            {
                $colors[$i] = $defaultColors[$i];
            }

            if(isset($colors[$i]))
            {
                if($colors[$i] == '')
                {
                    $colors[$i] = $defaultColors[$i];
                }
            }
        }

        foreach ($ids as $id) {
            $guidingParameters->push(GuidingParameter::find($id));
        }

        $guidingParameters2 = $this->projectPointMatrices()
        ->select('guiding_parameters.*')
        ->whereHas('guidingParameters')
        ->leftJoin('guiding_parameter_project_point_matrix', function($join) {
            $join->on('project_point_matrices.id', '=', 'guiding_parameter_project_point_matrix.project_point_matrix_id');
        })
        ->leftJoin('guiding_parameters', function($join) {
            $join->on('guiding_parameters.id', '=', 'guiding_parameter_project_point_matrix.guiding_parameter_id');
        })
        ->orderBy('guiding_parameters.id')
        ->distinct()
        ->get();

        foreach ($guidingParameters2 as $guidingParameter) {
            if(!in_array($guidingParameter->id, $ids)) {
                $guidingParameters->push($guidingParameter);
            }
        }

        $result[0] = $guidingParameters;
        $result[1] = $colors;

        return $result;
    }
}
