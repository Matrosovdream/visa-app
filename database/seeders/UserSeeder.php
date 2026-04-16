<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;

class UserSeeder extends Seeder
{

    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'pin' => Hash::make('111'),
                'role' => 1,
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('123456'),
                'pin' => Hash::make('222'),
                'role' => 2,
            ],
        ];

        foreach ($users as $user) {

            $userId = User::firstOrCreate(
                ['email' => $user['email']], // Check by email
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'pin' => $user['pin'],
                ]
            );

            // Backfill pin on pre-existing users that were created before the column existed.
            if (empty($userId->pin)) {
                $userId->forceFill(['pin' => $user['pin']])->saveQuietly();
            }

            // Assign roles
            $userId->roles()->sync($user['role']);
        }
    }

}
