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
        'name', 'status', 'adress', 'number', 'city', 'state', 'cep', 'district'
    ];

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
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

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

        $customers->orderBy($orderBy, $ascending);

        return $customers->paginate($perPage, ['*'], 'customers')->appends(request()->input());
    }

    /**
     * Get full adress
     * @return string
     */
    public function getFullAdress()
    {
        return "$this->adress, $this->number<br>$this->city - $this->state";
    }

}
