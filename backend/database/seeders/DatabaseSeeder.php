<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            EmployeeSeeder::class,
            ShiftTemplateSeeder::class,
        ]);

        Schedule::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'График',
                'status' => 'draft',
            ]
        );
    }
}
