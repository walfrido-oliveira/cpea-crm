<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnpj extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cnpj', 'corporate_name', 'unit'
    ];

    /**
     * Find users in dabase
     *
     * @param Array
     *
     * @return object
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

        $result = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['cnpj']))
            {
                if(!is_null($query['cnpj']))
                {
                    $q->where('cnpj', 'like','%' . $query['cnpj'] . '%');
                }
            }

            if(isset($query['corporate_name']))
            {
                if(!is_null($query['corporate_name']))
                {
                    $q->where('corporate_name', 'like','%' . $query['corporate_name'] . '%');
                }
            }

            if(isset($query['unit']))
            {
                if(!is_null($query['unit']))
                {
                    $q->where('unit', 'like','%' . $query['unit'] . '%');
                }
            }

        });

        $result->orderBy($orderBy, $ascending);

        return $result->paginate($perPage);
    }

    public function getFormattedCnpjAttribute()
    {
        return mask($this->cnpj, "##.###.###/####-##");
    }
}
