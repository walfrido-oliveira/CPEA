<?php

namespace App\Models;

use App\Models\Replace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lab extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'cod'
    ];

    /**
     * The Replaces.
     */
    public function replaces()
    {
        return $this->hasMany(Replace::class);
    }

    /**
     * Get formatted type
     *
     * @return string
     */
    public function getFormattedTypeAttribute()
    {
        switch ($this->type) {
            case 'external':
                return 'Laboratório (Externo)';
                break;

            case 'internal':
                return 'Laboratório (Interno)';
                break;
        }

        return '';
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

            if(isset($query['name']))
            {
                if(!is_null($query['name']))
                {
                    $q->where('name', 'like','%' . $query['name'] . '%');
                }
            }
        });

        $labs->orderBy($orderBy, $ascending);

        return $labs->paginate($perPage);
    }
}
