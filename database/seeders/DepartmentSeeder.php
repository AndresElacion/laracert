<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // php artisan db:seed --class=DepartmentSeeder
        Department::create([
            'name' => 'CS',
        ]);

        Department::create([
            'name' => 'IS',
        ]);
    }
}
