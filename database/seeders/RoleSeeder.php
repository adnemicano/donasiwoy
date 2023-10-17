<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // membuat isi data pada table role dengan isi kolom name dan guard_name
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        // penulisan case
        // camelCase = userSeeder
        // snake_case = user_seeder
        // KebabCase = UserSeeder
        // ALLCAPS = USERSEEDER
    }
}
