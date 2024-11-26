<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'description',
    'obs',
    'conversation_item_id',
    'value_type',
    'value',
    'additional_value',
    'user_id'
  ];

  /**
   * The Conversation Item
   */
  public function conversationItem()
  {
    return $this->belongsTo(ConversationItem::class);
  }

  /**
   * The user
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
