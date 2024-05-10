<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'direction_id', 'department_id', 'year', 'month', 'value'
  ];

  public function direction()
  {
    return $this->belongsTo(Direction::class);
  }

  public function department()
  {
    return $this->belongsTo(Department::class);
  }

  public static function filter($query)
  {
    $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
    $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
    $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

    $result = self::where(function ($q) use ($query) {
      if (isset($query['id'])) {
        if (!is_null($query['id'])) {
          $q->where('id', $query['id']);
        }
      }

      if (isset($query['direction_id'])) {
        if (!is_null($query['direction_id'])) {
          $q->where('direction_id', $query['direction_id']);
        }
      }

      if (isset($query['department_id'])) {
        if (!is_null($query['department_id'])) {
          $q->where('department_id', $query['department_id']);
        }
      }

      if (isset($query['year'])) {
        if (!is_null($query['year'])) {
          $q->where('year', $query['year']);
        }
      }

      if (isset($query['month'])) {
        if (!is_null($query['month'])) {
          $q->where('month', $query['month']);
        }
      }
    });

    $result->orderBy($orderBy, $ascending);

    return $result->paginate($perPage);
  }
}
