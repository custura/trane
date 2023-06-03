<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamProjectTaskBind;
use Illuminate\Database\Seeder;

class TeamTaskBindsTableSeeder extends Seeder
{
    public function run()
    {
        $binds = [
            [
                'team_id'    => 1,
                'project_id' => '1',
                'task_id' => '1',
            ],
            [
                'team_id'    => 1,
                'project_id' => '1',
                'task_id' => '2',
            ],
            [
                'team_id'    => 1,
                'project_id' => '2',
                'task_id' => '3',
            ],
            [
                'team_id'    => 1,
                'project_id' => '3',
                'task_id' => '4',
            ],
            [
                'team_id'    => 1,
                'project_id' => '4',
                'task_id' => '5',
            ],
        ];

        TeamProjectTaskBind::insert($binds);
    }
}
