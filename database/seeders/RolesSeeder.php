<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Role::factory(5)->create();
        Role::create([
            'name'=> 'admin'
        ]);
        Role::create([
            'name'=> 'editor'
        ]);
        Role::create([
            'name'=> 'viewer'
        ]);
    }
}
