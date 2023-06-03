<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamProjectClientBind;
use Illuminate\Database\Seeder;

class TeamClientBindsTableSeeder extends Seeder
{
    public function run()
    {
        $binds = [
            [
                'team_id'    => 1,
                'project_id' => '1',
                'client_id' => '1',
            ],
            [
                'team_id'    => 1,
                'project_id' => '2',
                'client_id' => '2',
            ],
            [
                'team_id'    => 1,
                'project_id' => '3',
                'client_id' => '3',
            ],
            [
                'team_id'    => 1,
                'project_id' => '4',
                'client_id' => '4',
            ],
        ];

        TeamProjectClientBind::insert($binds);
    }
}
