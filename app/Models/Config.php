<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

      /**
     * Add a configs value
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function add($key, $val, $type = 'string')
    {
        if ( self::has($key) ) {
            return self::set($key, $val, $type);
        }

        return self::create(['name' => $key, 'value' => $val, 'type' => $type]) ? $val : false;
    }

    /**
     * Get a config value
     *
     * @param $key
     * @param null $default
     * @return bool|int|mixed
     */
    public static function get($key, $default = null)
    {
        if ( self::has($key) ) {
            $config = self::getAllConfigs()->where('name', $key)->first();
            return self::castValue($config->value, $config->type);
        }

        return "";
    }

    /**
     * Set a value for config
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function set($key, $val, $type = 'string')
    {
        if ( $config = self::getAllConfigs()->where('name', $key)->first() ) {
            return $config->update([
                'name' => $key,
                'value' => $val,
                'type' => $type]) ? $val : false;
        }

        return self::add($key, $val, $type);
    }

    /**
     * Remove a config
     *
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        if( self::has($key) ) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Check if config exists
     *
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return (boolean) self::getAllConfigs()->whereStrict('name', $key)->count();
    }


    /**
     * Get the data type of a config
     *
     * @param $field
     * @return mixed
     */
    public static function getDataType($field)
    {
        return 'string' ;
    }


    /**
     * caste value into respective type
     *
     * @param $val
     * @param $castTo
     * @return bool|int
     */
    public static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;

            case 'bool':
            case 'boolean':
                return $val === 'true';
                break;

            default:
                return $val;
        }
    }

    /**
     * Get all the configs
     *
     * @return mixed
     */
    public static function getAllConfigs()
    {
        return self::all();
    }
}
