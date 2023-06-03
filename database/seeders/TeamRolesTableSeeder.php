<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamRole;
use Illuminate\Database\Seeder;

class TeamRolesTableSeeder extends Seeder
{
    public function run()
    {
        $teamroles = [
            [
                'id'            => 1,
                'team_id'       => NULL,
                'key'           => 'topmanager',
                'name'          => 'Top manager',
                'description'   => 'A person with all set of management functions.',
                'permissions'   => 'manage:user:create, manage:user:read, manage:user:update, manage:user:delete, manage:team:setting:delete,',
                'default'       => 1,
                'status'        => 1,
            ],
            [
                'id'            => 2,
                'team_id'       => NULL,
                'key'           => 'comanager',
                'name'          => 'Co-manager',
                'description'   => 'A person with a big set of management functions.',
                'permissions'   => 'manage:user:create, manage:user:read, manage:user:update, manage:user:delete, manage:team:setting:delete,',
                'default'       => 1,
                'status'        => 1,
            ],
            [
                'id'            => 3,
                'team_id'       => NULL,
                'key'           => 'manager',
                'name'          => 'Manager',
                'description'   => 'Group manager. Can do most of things for a group.',
                'permissions'   => 'manage:user:create, manage:user:read, manage:user:update, manage:user:delete, manage:team:setting:delete,',
                'default'       => 1,
                'status'        => 1,
            ],
            [
                'id'            => 4,
                'team_id'       => NULL,
                'key'           => 'supervisor',
                'name'          => 'Supervisor',
                'description'   => 'A person with a small set of management rights.',
                'permissions'   => 'manage:user:create, manage:user:read, manage:user:update, manage:user:delete, manage:team:setting:delete,',
                'default'       => 1,
                'status'        => 1,
            ],
            [
                'id'            => 5,
                'team_id'       => NULL,
                'key'           => 'worker',
                'name'          => 'Worker',
                'description'   => 'A regular member without management rights.',
                'permissions'   => 'manage:user:create, manage:user:read, manage:user:update, manage:user:delete, manage:team:setting:delete,',
                'default'       => 1,
                'status'        => 1,
            ],
            [
                'id'            => 6,
                'team_id'       => NULL,
                'key'           => 'client',
                'name'          => 'Client',
                'description'   => 'A client can view its own data.',
                'permissions'   => 'manage:user:create, manage:user:read, manage:user:update, manage:user:delete, manage:team:setting:delete,',
                'default'       => 1,
                'status'        => 1,
            ],
        ];

        TeamRole::insert($teamroles);
    }
}
