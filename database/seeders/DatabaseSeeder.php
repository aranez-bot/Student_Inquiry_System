<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed departments first
        $this->call(DepartmentSeeder::class);

        // Create test users for different roles
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'user_type' => 'super_admin',
            'department_id' => null,
        ]);

        $registrarDept = \App\Models\Department::where('slug', 'registrar')->first();
        $deptAdmin = User::factory()->create([
            'name' => 'Registrar Admin',
            'email' => 'registrar@example.com',
            'user_type' => 'department_admin',
            'department_id' => $registrarDept->id,
        ]);

        $student = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'student@example.com',
            'user_type' => 'student',
            'department_id' => null,
        ]);
    }
}
