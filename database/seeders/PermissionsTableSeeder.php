<?php

namespace Database\Seeders;

use Custura\Trane\Models\User\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_access',
            ],
            [
                'id'    => 2,
                'title' => 'privat_appointment_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
