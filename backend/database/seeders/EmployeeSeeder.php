<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Кузнецова Алина',
            'Волков Тимур',
            'Морозова Виктория',
            'Соколов Артём',
            'Лебедева Полина',
            'Новиков Кирилл',
            'Козлова Юлия',
            'Гаврилов Егор',
        ];

        foreach ($names as $fullName) {
            Employee::updateOrCreate(
                ['full_name' => $fullName],
                ['avatar_url' => null]
            );
        }
    }
}