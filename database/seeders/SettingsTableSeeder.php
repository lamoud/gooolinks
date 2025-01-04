<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'لـــــــــينك'],
            ['key' => 'site_description', 'value' => 'لـــــــــينك.'],
            ['key' => 'site_logo', 'value' => 'logo.png'],
            ['key' => 'site_icon', 'value' => 'icon.png'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
