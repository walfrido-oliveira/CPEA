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
        'name', 'field_type_id', 'type', 'desc', 'params', 'multiparameter'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'params' => 'array',
    ];


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

            if(isset($query['field_type_id']))
            {
                if(!is_null($query['field_type_id']))
                {
                    $q->where('field_type_id',  $query['field_type_id']);
                }
            }

            if(isset($query['type']))
            {
                if(!is_null($query['type']))
                {
                    $q->where('type', 'like', $query['type']);
                }
            }
        });

        $envionmentalAreas->orderBy($orderBy, $ascending);

        return $envionmentalAreas->paginate($perPage);
    }

    public static function types()
    {
        return ['Referência Externa' => 'Referência Externa', 'Referências' => 'Referências'];
    }

    /**
     * The Field type.
     */
    public function fieldType()
    {
        return $this->belongsTo(FieldType::class);
    }

    public static function paramsTypes() {
        return [
            'temperature' => 'Temperatura',
            'ph' => 'pH',
            'orp' => 'ORP',
            'conductivity' => 'Condutividade',
            'salinity' => 'Salinidade',
            'psi' => 'Press.',
            'sat' => 'Oxigênio Dissolvido (sat)',
            'conc' => 'Oxigênio Dissolvido (conc)',
            'eh' => 'EH',
            'ntu' => 'Turbidez',
            'chlorine' => 'Cloro Total',
            'residualchlorine' => 'Cloro Livre Residual',
            'voc' => 'VOC',
            'aspect' => 'Aspecto',
            'artificialdyes' => 'Corantes Artificiais',
            'floatingmaterials' => 'Materiais Flutuantes',
            'objectablesolidwaste' => 'Resíduos Sólidos Objetáveis',
            'visibleoilsandgreases' => 'Óleos e Graxas Visíveis'
        ];
    }
}
