<?php

namespace App\Models;

use App\Models\Config;
use App\Traits\Observable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConversationItem extends Model
{
    use HasFactory;

    use Observable;

    /**
     * String to describe the model being updated / deleted / created
     * @param Model $model
     * @return string
     */
    public static function logSubject(Model $model): string
    {
        return sprintf( "User [id:%d] %s/%s",
            $model->id, $model->name, $model->email
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_type', 'interaction_at', 'additive', 'cpea_linked_id', 'schedule_type',
        'schedule_name', 'schedule_at', 'schedule_details',
        'conversation_id', 'project_status_id', 'proposed_status_id', 'prospecting_status_id',
        'detailed_contact_id', 'organizer_id', 'user_id', 'item_details', 'direction_id', 'employee_id', 'order',
        'meeting_form', 'meeting_place', 'teams_url'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'interaction_at' => 'datetime',
        'schedule_at' => 'datetime',
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
     * The Direction
    */
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    /**
     * The Employee
    */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
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

    /**
     * The Attachments
    */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * The Values
    */
    public function values()
    {
        return $this->hasMany(Value::class);
    }

    /**
     * The Addresses
    */
    public function addresses()
    {
        return $this->hasMany(ScheduleAddress::class);
    }

    public function totalValues($type = null)
    {
        $sum = 0;
        foreach ($this->values as $value) {
            if($type && $type == $value->value_type) {
                $sum +=    $value->value;
            } else {
                $sum +=    $value->value;
            }
        }
        return $sum;
    }

    public function sendScheduleNotification()
    {
        $this->user->sendScheduleNotification($this);
    }

    public function sendAppovedProposalNotification()
    {
        $mailConversationApprovedUsersTemp = unserialize(Config::get('mail_conversation_approved_users'));
        $mailConversationApprovedDepartmentsTemp = unserialize(Config::get('mail_conversation_approved_departments'));
        $mailConversationApprovedDirectionsTemp = unserialize(Config::get('mail_conversation_approved_directions'));

        $mailConversationApprovedUsers = User::whereIn("id", is_array($mailConversationApprovedUsersTemp) ? $mailConversationApprovedUsersTemp : [])
        ->OrwhereHas('employee', function($q) use($mailConversationApprovedDepartmentsTemp) {
            $q->whereIn('department_id', is_array($mailConversationApprovedDepartmentsTemp) ? $mailConversationApprovedDepartmentsTemp : []);
        })
        ->OrwhereHas('employee', function($q) use($mailConversationApprovedDirectionsTemp) {
            $q->whereIn('direction_id', is_array($mailConversationApprovedDirectionsTemp) ? $mailConversationApprovedDirectionsTemp : []);
        })
        ->get();

        foreach ($mailConversationApprovedUsers as $user) {
            $user->sendAppovedProposalNotification($this);
        }
    }

    public function notify($isNew = true)
    {
        if($this->schedule_type == 'internal' && $isNew) {
            $this->sendScheduleNotification();
        }
        if($this->proposedStatus) {
            if($this->item_type == "Proposta" && $this->proposedStatus->name == 'Proposta Aprovada') {
                $this->sendAppovedProposalNotification();
            }
        }

    }
}
