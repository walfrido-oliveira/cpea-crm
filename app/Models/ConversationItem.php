<?php

namespace App\Models;

use App\Models\Config;
use App\Traits\Observable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExternalMeetingNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\NewScheduleNotification;

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
    return sprintf(
      "User [id:%d] %s/%s",
      $model->id,
      $model->name,
      $model->email
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
    'conversation_id', 'conversation_status_id', 'detailed_contact_id', 'organizer_id',
    'user_id', 'item_details', 'direction_id', 'employee_id', 'order',
    'meeting_form', 'meeting_place', 'teams_url', 'teams_id', 'teams_token', 'schedule_end', 'etapa_id',
    'ppi', 'cnpj_id', 'department_id', 'state', 'city', 'probability'
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'interaction_at' => 'datetime',
    'schedule_at' => 'datetime',
    'schedule_end' => 'datetime',
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
   * The ETAPA
   */
  public function etapa()
  {
    return $this->belongsTo(Etapa::class);
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
  public function conversationStatus()
  {
    return $this->belongsTo(ConversationStatus::class);
  }

  /**
   * Products
   */
  public function products()
  {
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

  public static function probabilities()
  {
    return ["10%" => "10%", "50%" => "50%", "90%" => "90%"];
  }

  public function totalValues($type = null)
  {
    $sum = 0;
    foreach ($this->values as $value) {
      if ($type && $type == $value->value_type) {
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

    foreach ($this->addresses as $address) {
      Notification::route('mail', [$address->address => $address->address_name])
        ->notify(new NewScheduleNotification($this));
    }
  }

  public function sendExternalMeetingNotification()
  {
    $this->user->sendExternalMeetingNotification($this);

    foreach ($this->addresses as $address) {
      Notification::route('mail', [$address->address => $address->address_name])
        ->notify(new ExternalMeetingNotification($this));
    }
  }

  public function sendAppovedProposalNotification()
  {
    $mailConversationApprovedUsersTemp = unserialize(Config::get('mail_conversation_approved_users'));
    $mailConversationApprovedDepartmentsTemp = unserialize(Config::get('mail_conversation_approved_departments'));
    $mailConversationApprovedDirectionsTemp = unserialize(Config::get('mail_conversation_approved_directions'));

    $mailConversationApprovedUsers = User::whereIn("id", is_array($mailConversationApprovedUsersTemp) ? $mailConversationApprovedUsersTemp : [])
      ->OrwhereHas('employee', function ($q) use ($mailConversationApprovedDepartmentsTemp) {
        $q->whereIn('department_id', is_array($mailConversationApprovedDepartmentsTemp) ? $mailConversationApprovedDepartmentsTemp : []);
      })
      ->OrwhereHas('employee', function ($q) use ($mailConversationApprovedDirectionsTemp) {
        $q->whereIn('direction_id', is_array($mailConversationApprovedDirectionsTemp) ? $mailConversationApprovedDirectionsTemp : []);
      })
      ->get();

    foreach ($mailConversationApprovedUsers as $user) {
      $user->sendAppovedProposalNotification($this);
    }
  }

  public function notify($isNew = true)
  {
    if ($this->schedule_type == 'internal' && $isNew) {
      $this->sendScheduleNotification();
    }

    if ($this->schedule_type == 'external' && $isNew) {
      $onlieMeetingResp = OnlineMeeting::createOnlineMeeting($this, Azure::user($this->organizer->email));
      $this->teams_url = $onlieMeetingResp->joinWebUrl;
      $this->teams_id = $onlieMeetingResp->joinMeetingIdSettings->joinMeetingId;
      $this->teams_token = $onlieMeetingResp->joinMeetingIdSettings->passcode;
      $this->save();
      $this->sendExternalMeetingNotification();
      OnlineMeeting::createEvent($this, Azure::user($this->organizer->email));
    }

    if ($this->proposedStatus) {
      if ($this->item_type == "Proposta" && $this->proposedStatus->name == 'Proposta Aprovada') {
        $this->sendAppovedProposalNotification();
      }
    }
  }

  /**
   * Find users in dabase
   *
   * @param Array
   *
   * @return object
   */
  public static function filter($query, $isCpeaId = false)
  {
    $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
    $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
    $orderBy = isset($query['order_by']) ? $query['order_by'] : "cpea_id";

    $result = self::where(function ($q) use ($query, $isCpeaId) {
      if (!$isCpeaId) $q->whereNull("cpea_id");
      if ($isCpeaId) $q->whereNotNull("cpea_id");

      if (isset($query['cpea_id'])) {
        if (!is_null($query['cpea_id'])) {
          $q->where('cpea_id', 'LIKE', "{$query['cpea_id']}%");
        }
      }

      if (isset($query['direction_id'])) {
        if (!is_null($query['direction_id'])) {
          $q->where('employees.direction_id', $query['direction_id']);
        }
      }

      if (isset($query['department_id'])) {
        if (!is_null($query['department_id'])) {
          $q->where('employees.department_id', $query['department_id']);
        }
      }

      if (isset($query['employee_id'])) {
        if (!is_null($query['employee_id'])) {
          $q->where('employee_id', $query['employee_id']);
        }
      }

      if (isset($query['customer_name'])) {
        if (!is_null($query['customer_name'])) {
          $q->where('customers.name', 'LIKE', "%{$query['customer_name']}%");
        }
      }

      if (isset($query['conversation_status_id'])) {
        if (!is_null($query['conversation_status_id'])) {
          $q->where('conversation_status_id', $query['conversation_status_id']);
        }
      }

      if (isset($query['product_id'])) {
        if (!is_null($query['product_id'])) {
          $q->whereIn('product_id', explode(",", $query['product_id']));
        }
      }
    });

    $result
      ->join("conversations", "conversations.id", "=", "conversation_id")
      ->leftJoin("customers", "customers.id", "=", "conversations.customer_id")
      ->leftJoin("employees", "employees.id", "=", "conversation_items.employee_id")
      ->leftJoin("conversation_item_product", "conversation_item_product.conversation_item_id", "=", "conversation_items.id")
      ->select("conversation_items.*");

    if ($orderBy == 'cpea_id') {
      $result->orderByRaw("cast($orderBy as unsigned) $ascending");
    } else {
      $result->orderBy($orderBy, $ascending);
    }


    return $result->paginate($perPage);
  }
}
