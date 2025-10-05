<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'value'];

    /**
     * Get a setting value by its name.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public static function get($name, $default = null)
    {
        $setting = static::where('name', $name)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Get all settings as an associative array.
     *
     * @return array
     */
    public static function getAll()
    {
        return static::pluck('value', 'name')->toArray();
    }

    /**
     * Update or create a setting.
     *
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public static function set($name, $value)
    {
        $setting = static::updateOrCreate(
            ['name' => $name],
            ['value' => $value]
        );

        return $setting->wasRecentlyCreated || $setting->wasChanged();
    }

    /**
     * Get all default settings defined in the migration.
     *
     * @return array
     */
    public static function getDefaultSettings()
    {
        return [
            // General Platform Settings
            'platform_name' => 'My Platform',
            'platform_logo' => null,
            'platform_favicon' => null,
            'support_email' => 'support@example.com',
            'support_contact_info' => null,
            'default_language' => 'en',
            'default_timezone' => 'UTC',
            'maintenance_mode' => '0', // 0 = OFF, 1 = ON

            // Financial Settings
            'commission_rate' => '5', // 5%
            'default_currency' => 'USD',
            'minimum_withdrawal_amount' => '10',
            'withdrawal_processing_time' => '3', // days
        ];
    }
}