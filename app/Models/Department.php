<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'acronym', 'direction_id'
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

            if(isset($query['direction_id']))
            {
                if(!is_null($query['direction_id']))
                {
                    $q->where('direction_id', $query['direction_id']);
                }
            }

            if(isset($query['name']))
            {
                if(!is_null($query['name']))
                {
                    $q->where('name', 'like','%' . $query['name'] . '%');
                }
            }

            if(isset($query['acronym']))
            {
                if(!is_null($query['acronym']))
                {
                    $q->where('acronym', 'like','%' . $query['acronym'] . '%');
                }
            }

        });

        $result->orderBy($orderBy, $ascending);

        return $result->paginate($perPage);
    }

    /**
     * The Customer
    */
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
}
