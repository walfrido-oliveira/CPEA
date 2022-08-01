<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'field_type_id'
    ];

     /**
     * Get field type
     *
     * @return array
     */
    public function fieldType()
    {
        return $this->belongsToMany(FieldType::class);
    }


    /**
     * Find in dabase
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

        $envionmentalAreas = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['name']))
            {
                if(!is_null($query['project_id']))
                {
                    $q->where('name', 'like','%' . $query['name'] . '%');
                }
            }

            if(isset($query['type']))
            {
                if(!is_null($query['type']))
                {
                    $q->where('type', 'like', $query['type']);
                }
            }

            if(isset($query['q']))
            {
                if(!is_null($query['q']))
                {
                    $q->where('project_id', 'like', '%' . $query['q'] . '%');
                }
            }

        });

        $envionmentalAreas->orderBy($orderBy, $ascending);

        return $envionmentalAreas->paginate($perPage);
    }
}
