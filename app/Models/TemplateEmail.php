<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateEmail extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'subject',
        'description',
        'notification',
        'tags',
        'value'
    ];

    /**
     * Get a template value by name
     *
     * @param string $key
     */
    public static function getValue($key)
    {
        $result = self::where('name', $key)->first();
        if($result)
        {
            $value = $result->value;
            return $value;
        }
        return null;
    }

    /**
     * Get a template displayed name by name
     *
     * @param string $key
     */
    public static function getSubject($key)
    {
        $result = self::where('name', $key)->first();
        if($result)
        {
            $subject = $result->subject;
            return $subject;
        }
        return null;
    }
}
