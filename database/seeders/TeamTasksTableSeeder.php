<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamProjectTask;
use Illuminate\Database\Seeder;

class TeamTasksTableSeeder extends Seeder
{
    public function run()
    {
        $tasks = [
            [
                'id'    => 1,
                'team_id'    => 1,
                'title' => 'Task test 1',
                'description' => 'description 1',
                'status' => '1',
            ],
            [
                'id'    => 2,
                'team_id'    => 1,
                'title' => 'Task test 2',
                'description' => 'description 2',
                'status' => '1',
            ],
            [
                'id'    => 3,
                'team_id'    => 1,
                'title' => 'Task test 3',
                'description' => 'description 3',
                'status' => '1',
            ],
            [
                'id'    => 4,
                'team_id'    => 1,
                'title' => 'Task test 4',
                'description' => 'description 4',
                'status' => '1',
            ],
            [
                'id'    => 5,
                'team_id'    => 1,
                'title' => 'Task test 5',
                'description' => 'description 5',
                'status' => '1',
            ],
        ];

        TeamProjectTask::insert($tasks);
    }
}
