<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ref extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'field', 'turbidity'
    ];

    public static function getFieldsArray()
    {
        return [
            'Água para Consumo Humano' => 'Água para Consumo Humano',
            'Água Subterrânea por Bailer' => 'Água Subterrânea por Bailer',
            'Água Subterrânea por Baixa Vazão' => 'Água Subterrânea por Baixa Vazão',
            'Água Superficial' => 'Água Superficial',
            'Ar Ambiente' => 'Ar Ambiente',
            'Ar do solo'=> 'Ar do solo',
            'Efluente' => 'Efluente',
            'Resíduo Sólido' => 'Resíduo Sólido',
            'Sedimento' => 'Sedimento',
            'Solo' => 'Solo'
        ];
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
                if(!is_null($query['name']))
                {
                    $q->where('name', 'like','%' . $query['name'] . '%');
                }
            }

            if(isset($query['field']))
            {
                if(!is_null($query['field']))
                {
                    $q->where('field', 'like','%' . $query['field'] . '%');
                }
            }
        });

        $envionmentalAreas->orderBy($orderBy, $ascending);

        return $envionmentalAreas->paginate($perPage);
    }
}
