<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cpea_id', 'customer_id'
    ];

    /**
     * The Customer
    */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
