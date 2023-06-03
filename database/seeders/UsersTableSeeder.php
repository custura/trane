<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Custura\Trane\Trane;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            'Custura Laurentiu' => 'mail@custura.de',
            'Admin' => 'admin@custura.de',
            'User' => 'user@custura.de',
        ];

        foreach ($users as $name => $email) {
            DB::transaction(function () use ($name, $email) {
                return tap(User::create([
                    'name' => $name,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => Hash::make('123qwea'),
                ]), function (User $user) {
                        $user->roles()->attach(2);
                        $this->createTeam($user);
                });
          });
        }
    }
    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}


