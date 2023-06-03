<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamProjectUserBind;
use Illuminate\Database\Seeder;

class TeamProjectBindsTableSeeder extends Seeder
{
    public function run()
    {
        $binds = [
            [
                'id' => 1,
                'user_id'    => 1,
                'team_id'    => 1,
                'project_id' => 1,
                'rate' => 100,
                'status' => 1,
            ],
            [
                'id' => 2,
                'user_id'    => 1,
                'team_id'    => 1,
                'project_id' => 2,
                'rate' => 100,
                'status' => 1,
            ],
            [
                'id' => 3,
                'user_id'    => 1,
                'team_id'    => 1,
                'project_id' => 3,
                'rate' => 100,
                'status' => 1,
            ],
            [
                'id' => 4,
                'user_id'    => 1,
                'team_id'    => 1,
                'project_id' => 4,
                'rate' => 100,
                'status' => 1,
            ],
        ];

        TeamProjectUserBind::insert($binds);
    }
}
