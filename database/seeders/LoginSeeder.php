<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Seeder;

class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Users();
        $user->id = strtolower((string) \Illuminate\Support\Str::ulid());
        $user->name = 'Indra Wahyudi';
        $user->email = 'indrawahyudi2710@gmail.com';
        $user->password = '$BSSVPRNHGB$c3284d0f94606de1fd2af172aba15bf3'; //admin
        $user->use_oracle = false;
        $user->save();
    }
}
