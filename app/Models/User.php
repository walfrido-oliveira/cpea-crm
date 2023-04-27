<?php

namespace App\Models;

use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Notifications\NewUserNotification;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UpdateUserInformationNotification;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'last_name', 'phone', 'password', 'status',
        'crq', 'department_id', 'signer', 'occupation_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Send update mail to user
     *
     * @return void
     */
    public function sendUpdateUserInformationNotification()
    {
        $this->notify(new UpdateUserInformationNotification($this));
    }

    /**
     * Get first role
     */
    public function getRoleAttribute()
    {
      $role = $this->roles()->first();
      return $role->name;
    }

    /**
     * Find users in dabase
     *
     * @param Array
     *
     * @return array
     */
    public static function filter($query)
    {
        $perPage = isset($query['paginate_per_page']) ? $query['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE;
        $ascending = isset($query['ascending']) ? $query['ascending'] : DEFAULT_ASCENDING;
        $orderBy = isset($query['order_by']) ? $query['order_by'] : DEFAULT_ORDER_BY_COLUMN;

        $users = self::where(function($q) use ($query) {
            if(isset($query['id']))
            {
                if(!is_null($query['id']))
                {
                    $q->where('id', $query['id']);
                }
            }

            if(isset($query['roles']))
            {
                if(!is_null($query['roles']))
                {
                    $q->whereHas('roles', function($q) use ($query) {
                        $q->where('roles.name', $query['roles']);
                    });
                }
            }

            if(isset($query['name']))
            {
                if(!is_null($query['name']))
                {
                    $q->where('name', 'like','%' . $query['name'] . '%');
                }
            }
        });

        if($orderBy == 'role')
        {
            $users->leftJoin('model_has_roles', function ($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id')
                        ->where('model_has_roles.model_type', '=', 'app\Models\User');
            })
            ->orderBy('model_has_roles.role_id', $ascending);
        }
        else
        {
            $users->orderBy($orderBy, $ascending);
        }

        return $users->paginate($perPage);
    }

    /**
     * Get full name user
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
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

    public static function getSignerPath()
    {
        return "storage/img/signers";
    }

    /**
     * Send new user notification
     *
     * @return void
     */
    public function sendNewUserNotification()
    {
        $token = app('auth.password')->broker('invites')->createToken($this);

        DB::table(config('auth.passwords.users.table'))->insert([
            'email' => $this->email,
            'token' => $token
        ]);

        $url = url(route('password.reset', [
            'token' => $token,
            'email' =>  $this->email,
            'new_user' => true
        ], false));

        $this->notify(new NewUserNotification($this, $url));
    }
}
