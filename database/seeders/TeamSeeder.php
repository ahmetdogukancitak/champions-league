<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run()
    {
        Team::create([
            'name' => 'Team A',
            'strength' => 90,
        ]);

        Team::create([
            'name' => 'Team B',
            'strength' => 80,
        ]);

        Team::create([
            'name' => 'Team C',
            'strength' => 70,
        ]);

        Team::create([
            'name' => 'Team D',
            'strength' => 60,
        ]);
    }
}
