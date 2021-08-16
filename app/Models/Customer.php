<?php

namespace App\Models;

use App\Models\PointIdentification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status'
    ];

    /**
     * Get point Identification  array
     *
     * @return array
     */
    public function pointIdentifications()
    {
        return $this->belongsToMany(PointIdentification::class);
    }

    /**
     * Get status array
     *
     * @return Array
     */
    public static function getStatusArray()
    {
        return  ['active' => 'Ativo', 'inactive' => 'Inativo'];
    }

     /**
     * Find customers in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : 5;
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';

        $customers = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['roles']))
            {
                if(!is_null($query['roles']))
                {
                    $q->whereHas('roles', function($q) use ($query) {
                        $q->where('roles.name', $query['roles']);
                    });
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
            $customers->orderBy('created_at', 'desc');
        }
        else
        {
            $customers->orderBy($query['order_by'], $ascending);
        }

        return $customers->paginate($perPage);
    }

}
