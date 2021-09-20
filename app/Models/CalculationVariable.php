<?php

namespace App\Models;

use App\Models\CalculationParameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalculationVariable extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'calculation_parameter_id', 'name'
    ];

    /**
     * The calculation Parameter
     */
    public function calculationParameter()
    {
        return $this->belongsTo(CalculationParameter::class);
    }

    /**
     * Find unity in dabase
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

        $unities = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['calculation_parameter_id']))
            {
                if(!is_null($query['calculation_parameter_id']))
                {
                    $q->where('calculation_parameter_id', $query['calculation_parameter_id']);
                }
            }

            if(isset($query['name']))
            {
                if(!is_null($query['name']))
                {
                    $q->where('name', 'like', '%' . $query['name'] . '%');
                }
            }

        });

        $unities->orderBy($orderBy, $ascending);

        return $unities->paginate($perPage);
    }
}
