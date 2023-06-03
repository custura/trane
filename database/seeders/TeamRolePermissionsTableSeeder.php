<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamRolePermission;
use Illuminate\Database\Seeder;

class TeamRolePermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $teamrolepermissions = [
            [
                'title' => 'manage:user:read',
            ],
            [
                'title' => 'manage:user:create',
            ],
            [
                'title' => 'manage:user:delete',
            ],
            [
                'title' => 'manage:user:update',
            ],
            [
                'title' => 'manage:team:setting:delete',
            ],
        ];

        TeamRolePermission::insert($teamrolepermissions);
    }
}
