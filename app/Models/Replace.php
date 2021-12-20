<?php

namespace App\Models;

use App\Models\Lab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Replace extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lab_id', 'from', 'to'
    ];

    /**
     * The Lab.
     */
    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    /**
     * Find users in dabase
     *
     * @param Array
     *
     * @return object
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

            if(isset($query['from']))
            {
                if(!is_null($query['from']))
                {
                    $q->where('from', 'like','%' . $query['from'] . '%');
                }
            }

            if(isset($query['to']))
            {
                if(!is_null($query['to']))
                {
                    $q->where('to', 'like','%' . $query['to'] . '%');
                }
            }
        });

        $labs->orderBy($orderBy, $ascending);

        return $labs->paginate($perPage);
    }
}
