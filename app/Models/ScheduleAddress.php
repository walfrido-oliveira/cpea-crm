<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleAddress extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_name', 'address', 'conversation_item_id', 'obs'
    ];

    /**
     * The Conversation Item
    */
    public function conversationItem()
    {
        return $this->belongsTo(ConversationItem::class);
    }
}
