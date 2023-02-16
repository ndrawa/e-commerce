<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'id' => strtolower((string) \Illuminate\Support\Str::ulid()),
                'name' => 'Admin',
                'key' => 'ADMIN',
            ],
            [
                'id' => strtolower((string) \Illuminate\Support\Str::ulid()),
                'name' => 'User',
                'key' => 'USER',
            ],
        ]);
    }
}
