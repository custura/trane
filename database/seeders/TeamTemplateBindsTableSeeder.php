<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamProjectTemplateBind;
use Illuminate\Database\Seeder;

class TeamTemplateBindsTableSeeder extends Seeder
{
    public function run()
    {
        $binds = [
            [
                'team_id'    => 1,
                'project_id' => '1',
                'template_id' => '1',
            ],
            [
                'team_id'    => 1,
                'project_id' => '1',
                'template_id' => '2',
            ],
            [
                'team_id'    => 1,
                'project_id' => '2',
                'template_id' => '3',
            ],
            [
                'team_id'    => 1,
                'project_id' => '3',
                'template_id' => '4',
            ],
            [
                'team_id'    => 1,
                'project_id' => '4',
                'template_id' => '5',
            ],
        ];

        TeamProjectTemplateBind::insert($binds);
    }
}
