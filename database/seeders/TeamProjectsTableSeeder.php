<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamProject;
use Illuminate\Database\Seeder;

class TeamProjectsTableSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'id'    => 1,
                'team_id'    => 1,
                'title' => 'Project 1',
                'description' => 'description 1',
                'pause_time_1' => '00:10:00',
                'pause_time_2' => '00:30:00',
                'pause_time_3' => '00:10:00',
                'pause_time_4' => '00:10:00',
                'work_time_1' => '02:10:00',
                'work_time_2' => '01:10:00',
                'work_time_3' => '03:10:00',
                'work_time_4' => '01:10:00',
                'tasks' => '1, 3, 2',
                'status' => '1',
            ],
            [
                'id'    => 2,
                'team_id'    => 1,
                'title' => 'Project 2',
                'description' => 'description 2',
                'pause_time_1' => '00:10:00',
                'pause_time_2' => '00:30:00',
                'pause_time_3' => '00:10:00',
                'pause_time_4' => '00:10:00',
                'work_time_1' => '02:10:00',
                'work_time_2' => '01:10:00',
                'work_time_3' => '03:10:00',
                'work_time_4' => '01:10:00',
                'tasks' => '1, 3, 2',
                'status' => '1',
            ],
            [
                'id'    => 3,
                'team_id'    => 1,
                'title' => 'Project 3',
                'description' => 'description 3',
                'pause_time_1' => '00:10:00',
                'pause_time_2' => '00:30:00',
                'pause_time_3' => '00:10:00',
                'pause_time_4' => '00:10:00',
                'work_time_1' => '02:10:00',
                'work_time_2' => '01:10:00',
                'work_time_3' => '03:10:00',
                'work_time_4' => '01:10:00',
                'tasks' => '1, 3, 2',
                'status' => '1',
            ],
            [
                'id'    => 4,
                'team_id'    => 1,
                'title' => 'Project 4',
                'description' => 'description 4',
                'pause_time_1' => '00:10:00',
                'pause_time_2' => '00:30:00',
                'pause_time_3' => '00:10:00',
                'pause_time_4' => '00:10:00',
                'work_time_1' => '02:10:00',
                'work_time_2' => '01:10:00',
                'work_time_3' => '03:10:00',
                'work_time_4' => '01:10:00',
                'tasks' => '1, 3, 2',
                'status' => '1',
            ],
        ];

        TeamProject::insert($projects);
    }
}
