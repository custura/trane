<?php

namespace Database\Seeders;

use Custura\Trane\Models\Team\TeamProjectClient;
use Illuminate\Database\Seeder;

class TeamClientsTableSeeder extends Seeder
{
    public function run()
    {
        $clients = [
            [
                'id'    => 1,
                'team_id'    => 1,
                'client_name' => 'Client test 1',
                'client_adress' => 'client_adress 1',
                'projects' => '1, 3, 5',
                'status' => '1',
            ],
            [
                'id'    => 2,
                'team_id'    => 1,
                'client_name' => 'Client test 2',
                'client_adress' => 'client_adress 2',
                'projects' => '1, 3, 5',
                'status' => '1',
            ],
            [
                'id'    => 3,
                'team_id'    => 1,
                'client_name' => 'Client test 3',
                'client_adress' => 'client_adress 3',
                'projects' => '1, 3, 5',
                'status' => '1',
            ],
            [
                'id'    => 4,
                'team_id'    => 1,
                'client_name' => 'Client test 4',
                'client_adress' => 'client_adress 4',
                'projects' => '1, 3, 5',
                'status' => '1',
            ],
        ];

        TeamProjectClient::insert($clients);
    }
}
