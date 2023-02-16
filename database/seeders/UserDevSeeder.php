<?php

namespace Database\Seeders;

use App\Models\Lab;
use App\Models\UserLab;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserDevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('key', 'USER')->first();
        $user = Users::where('email', 'indrawahyudi2710@gmail.com')->first();
        if ($role) {
            UserRole::insert(
                [
                    [
                        'id' => strtolower((string) \Illuminate\Support\Str::ulid()),
                        'id_user' => $user->id,
                        'id_role' => $role->id,
                        'description' => 'USER'
                    ]
                ]
            );
        }
    }
}
