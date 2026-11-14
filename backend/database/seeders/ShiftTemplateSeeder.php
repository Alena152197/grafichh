<?php

namespace Database\Seeders;

use App\Models\ShiftTemplate;
use Illuminate\Database\Seeder;

class ShiftTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Утро',
                'slug' => 'morning',
                'start_time' => '07:00',
                'end_time' => '15:00',
                'duration_hours' => 8,
                'color' => '#E8E7FF',
            ],
            [
                'name' => 'День',
                'slug' => 'day',
                'start_time' => '10:00',
                'end_time' => '18:00',
                'duration_hours' => 8,
                'color' => '#DCEBFF',
            ],
            [
                'name' => 'Вечер',
                'slug' => 'evening',
                'start_time' => '15:00',
                'end_time' => '23:00',
                'duration_hours' => 8,
                'color' => '#E6D9FF',
            ],
        ];

        foreach ($templates as $template) {
            ShiftTemplate::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
}
