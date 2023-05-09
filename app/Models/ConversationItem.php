<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_type', 'interaction_at', 'additive', 'cpea_linked_id', 'schedule_type',
        'schedule_name', 'schedule_at', 'addressees', 'optional_addressees', 'schedule_details',
        'conversation_id', 'project_status_id', 'proposed_status_id', 'prospecting_status_id',
        'detailed_contact_id', 'organizer_id', 'user_id', 'item_details'
    ];

    /**
     * The Conversation
    */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * The contact
    */
    public function detailedContact()
    {
        return $this->belongsTo(DetailedContact::class);
    }

    /**
     * The organizer
    */
    public function organizer()
    {
        return $this->belongsTo(User::class, "organizer_id");
    }

    /**
     * The user
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The  project status
    */
    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    /**
     * The Proposed Status
    */
    public function proposedStatus()
    {
        return $this->belongsTo(ProposedStatus::class);
    }

    /**
     * The Prospecting Status
    */
    public function prospectingStatus()
    {
        return $this->belongsTo(ProspectingStatus::class);
    }

    /**
     * Products
     */
    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
