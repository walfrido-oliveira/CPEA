<?php

namespace App\Models;

use App\Models\Unity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unity_id', 'unity_cod', 'name', 'conversion_amount'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'conversion_amount' => 'double',
    ];

    /**
     * The unity
     */
    public function unity()
    {
        return $this->belongsTo(Unity::class);
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
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : 5;
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';

        $unities = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['unity_cod']))
            {
                if(!is_null($query['unity_cod']))
                {
                    $q->where('unity_cod', 'like','%' . $query['unity_cod'] . '%');
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
            $unities->orderBy('created_at', 'desc');
        }
        else
        {
            $unities->orderBy($query['order_by'], $ascending);
        }

        return $unities->paginate($perPage);
    }
}
