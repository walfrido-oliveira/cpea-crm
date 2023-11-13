<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'occupation_id',
        'direction_id',
        'department_id',
        'name',
        'registration',
        'user_id',
        'project_manager',
        'status'
    ];


    /**
     * The occupation
     */
    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    /**
     * The occupation
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * The directions
     */
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    /**
     * The user
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

            if(isset($query['status']))
            {
                if(!is_null($query['status']))
                {
                    $q->where('status', $query['status']);
                }
            }

            if(isset($query['department_id']))
            {
                if(!is_null($query['department_id']))
                {
                    $q->where('department_id', $query['department_id']);
                }
            }

            if(isset($query['direction_id']))
            {
                if(!is_null($query['direction_id']))
                {
                    $q->where('direction_id', $query['direction_id']);
                }
            }

            if(isset($query['registration']))
            {
                if(!is_null($query['registration']))
                {
                    $q->where('registration', $query['registration']);
                }
            }

            if(isset($query['name']))
            {
                if(!is_null($query['name']))
                {
                    $q->whereHas('user', function($q) use($query) {

                        $q->where('users.name', 'like','%' . $query['name'] . '%');
                    });
                }
            }

            if(isset($query['user_id']))
            {
                if(!is_null($query['user_id']))
                {
                    $q->where('user_id', $query['user_id'] );
                }
            }
        });

        $result->orderBy($orderBy, $ascending);

        return $result->paginate($perPage);
    }
}
