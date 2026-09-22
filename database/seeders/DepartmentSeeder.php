<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'TI / Suporte', 'code' => 'TI'],
            ['name' => 'Sistemas & Software', 'code' => 'SIS'],
            ['name' => 'Recursos Humanos', 'code' => 'RH'],
            ['name' => 'Infraestrutura & Manutenção', 'code' => 'INFRA'],
        ];

        foreach ($departments as $department) {
            Department::query()->updateOrCreate(
                ['code' => $department['code']],
                ['name' => $department['name']],
            );
        }
    }
}
