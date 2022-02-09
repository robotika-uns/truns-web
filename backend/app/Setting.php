<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';

    protected $guarded = ['roles'];

    public static function get($key)
    {
        $setting = self::where('name', $key)->first();

        if ($setting) {
            return $setting->value;
        }

        if (!config("setting.{$key}")) {
            return 'setting.invalid';
        }

        $new_setting = new self;
        $new_setting->name = $key;
        $new_setting->value = config("setting.{$key}.default");
        $new_setting->roles = config("setting.{$key}.roles");
        $new_setting->save();

        return $new_setting->value;
    }

    public static function set($key, $value)
    {
        $setting = self::where('name', $key)->first();

        if ($setting) {
            $setting->value = $value;
            $setting->save();
            return $setting->value;
        }

        $new_setting = self::create([
            'name'  => $key,
            'value' => $value,
            'roles' => config("setting.{$key}.roles")
        ]);

        return $new_setting->value;
    }

    protected $casts = [
        'roles' => 'array',
    ];
}
