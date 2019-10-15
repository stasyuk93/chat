<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'remember_token' => Hash::make('admin'),
            'password' => Hash::make('1234'),
        ]);
        $user->roles()->save(Role::where('name', 'admin')->first());
    }
}
