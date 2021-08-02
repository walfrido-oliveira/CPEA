<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointIdentification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area', 'identification'
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

            if(isset($query['area']))
            {
                if(!is_null($query['area']))
                {
                    $q->where('area', 'like','%' . $query['area'] . '%');
                }
            }

            if(isset($query['identification']))
            {
                if(!is_null($query['identification']))
                {
                    $q->where('identification', 'like','%' . $query['identification'] . '%');
                }
            }
        })->paginate($perPage);

        return $users;
    }
}
