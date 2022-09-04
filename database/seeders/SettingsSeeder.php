<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'key' => 'adicional.frete',
                'value' => 0,
                'description' => 'Taxa cobrada sobre o valor do frete'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate([
                'key' => $setting['key']
            ],
            [
                'value' => $setting['value'],
                'description' => $setting['description']
            ]);
        }
    }
}
