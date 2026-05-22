<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'description'];

    // Static cache for settings to avoid redundant queries in same request
    protected static $cachedSettings = [];

    public static function get($key, $default = null)
    {
        if (empty(self::$cachedSettings)) {
            try {
                self::$cachedSettings = self::pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                return $default;
            }
        }

        return array_key_exists($key, self::$cachedSettings) ? self::$cachedSettings[$key] : $default;
    }
}
