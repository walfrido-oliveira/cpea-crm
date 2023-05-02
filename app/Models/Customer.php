<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cnpj', 'corporate_name', 'obs', 'competitors', 'segment_id', 'sector_id', 'status',
        'created_user', 'updated_user'
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
     * The Segment
    */
    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    /**
     * The Sector
    */
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * The Creator
    */
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    /**
     * The Update
    */
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user');
    }

    /**
     * The Contacts
    */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

     /**
     * The Addresses
    */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getFormattedCnpjAttribute()
    {
        return mask($this->cnpj, "##.###.###/####-##");
    }

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

            if(isset($query['segment_id']))
            {
                if(!is_null($query['segment_id']))
                {
                    $q->where('segment_id', $query['segment_id']);
                }
            }

            if(isset($query['status']))
            {
                if(!is_null($query['status']))
                {
                    $q->where('status', $query['status']);
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

        $result->orderBy($orderBy, $ascending);

        return $result->paginate($perPage);
    }
}
