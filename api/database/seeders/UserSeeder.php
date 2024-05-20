<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdmin();
    }

    private function createAdmin(): void
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'Admin';
        $user->email = 'admin@mail.com';
        $user->password = Hash::make('admin');
        $user->role = 'admin';
        $user->save();
    }
}
