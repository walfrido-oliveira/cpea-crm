<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'obs', 'conversation_item_id', 'path'
    ];

    /**
     * The Conversation Item
    */
    public function conversationItem()
    {
        return $this->belongsTo(ConversationItem::class);
    }

    public function getUrlAttribute() {
        return Storage::url($this->path);
    }
}
