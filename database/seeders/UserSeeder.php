<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        $roles = ['admin', 'manager', 'user'];

        foreach ($roles as $element) {
            $role = new Role();
            $role->name = $element;
            $role->save();
        }

        $users = [
            ['name'=> 'admin', 'username'=> 'admin', 'email'=> 'admin@gmail.com', 'password'=>'password', 'role_id'=> 1],
            ['name'=> 'Manager', 'username'=> 'Manager', 'email'=> 'Manager@gmail.com', 'password'=>'password', 'role_id'=> 2],
            ['name'=> 'user', 'username'=> 'User', 'email'=> 'user@gmail.com', 'password'=>'password', 'role_id'=> 3],
        ];

        foreach($users as $user){
            User::create($user);
        }

    }
}
