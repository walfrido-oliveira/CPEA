<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
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
}
