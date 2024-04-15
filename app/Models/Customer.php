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
        'created_user_id', 'updated_user_id', 'customer_id'
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
     * The Customer
    */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The Customers
    */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'customer_id', 'id');
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
        return $this->belongsTo(User::class, 'created_user_id');
    }

    /**
     * The Update
    */
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    /**
     * The Contacts
    */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * The Detailed Contacts
    */
    public function detailedContats()
    {
        return $this->hasMany(DetailedContact::class);
    }

    /**
     * The Conversations
    */
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
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

    public function getIsNewCustomerAttribute()
    {
        $id = $this->id;
        $month = now()->subMonth(Config::get('new_customer_months'));
        $conversationItems = ConversationItem::where("item_type", "Proposta")
        ->whereBetween("interaction_at", [$month, now()])
        ->where("conversation_status_id", 14)
        ->whereHas("conversation", function($q) use($id) {
            $q->where("customer_id", $id);
        })
        ->get();
        return count($conversationItems) == 0;
    }

    /**
     * Find users in dabase
     *
     * @param Array
     *
     * @return object
     */
    public static function filter($query, $iscompany = false)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

        $result = self::where(function($q) use ($query, $iscompany) {
            if(!$iscompany) $q->whereNull("customer_id");
            if($iscompany) $q->whereNotNull("customer_id");

            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['customer_id']))
            {
                if(!is_null($query['customer_id']))
                {
                    $q->where('customer_id', $query['customer_id']);
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

            if(isset($query['new_customer']))
            {
                if($query['new_customer'] == 0)
                {
                    $month = now()->subMonth(Config::get('new_customer_months'));
                    $ids = Conversation::whereIn('id', ConversationItem::where("item_type", "Proposta")
                    ->whereBetween("interaction_at", [$month, now()])
                    ->where("conversation_status_id", 14)
                    ->pluck("conversation_id"))->pluck('customer_id');
                    $q->whereIn("id", $ids);
                }

                if($query['new_customer'] == 1)
                {
                    $month = now()->subMonth(Config::get('new_customer_months'));
                    $ids = Conversation::whereIn('id', ConversationItem::where("item_type", "Proposta")
                    ->whereBetween("interaction_at", [$month, now()])
                    ->where("conversation_status_id", 14)
                    ->pluck("conversation_id"))->pluck('customer_id');
                    $q->whereNotIn("id", $ids);
                }
            }

        });

        $result->orderBy($orderBy, $ascending);

        return $result->paginate($perPage);
    }
}
