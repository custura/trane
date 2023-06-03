<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamProjectTemplate;
use Illuminate\Database\Seeder;

class TeamTemplatesTableSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'id'    => 1,
                'team_id'    => 1,
                'title' => 'Template test 1',
                'description' => 'description 1',
                'content' => 'content 1',
                'status' => '1',
            ],
            [
                'id'    => 2,
                'team_id'    => 1,
                'title' => 'Template test 2',
                'description' => 'description 2',
                'content' => 'Content pentru test 2',
                'status' => '1',
            ],
            [
                'id'    => 3,
                'team_id'    => 1,
                'title' => 'Template test 3',
                'description' => 'description 3',
                'content' => 'Content pentru test 3',
                'status' => '1',
            ],
            [
                'id'    => 4,
                'team_id'    => 1,
                'title' => 'Template test 4',
                'description' => 'description 4',
                'content' => 'Content pentru test 4',
                'status' => '1',
            ],
            [
                'id'    => 5,
                'team_id'    => 1,
                'title' => 'Template test 5',
                'description' => 'description 5',
                'content' => 'Content pentru test 5',
                'status' => '1',
            ],
        ];

        TeamProjectTemplate::insert($templates);
    }
}
