<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeGeodeticSystem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Find users in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = 10;
        if(isset($query['paginate_per_page'])) $perPage = $query['paginate_per_page'];

        $users = self::where(function($q) use ($query) {
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
        })->paginate($perPage);

        return $users;
    }
}
