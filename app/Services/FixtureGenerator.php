<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Game;

class FixtureGenerator
{
    public function generate()
    {
        $teams = Team::all();

        $teamIds = $teams->pluck('id')->toArray();
        $weeks = [1, 2, 3, 4, 5, 6];

        // Çift devreli lig usulüne göre fikstür oluşturma
        $matches = [];

        foreach ($teamIds as $homeId) {
            foreach ($teamIds as $awayId) {
                if ($homeId != $awayId) {
                    $matches[] = [
                        'home_team_id' => $homeId,
                        'away_team_id' => $awayId,
                    ];
                }
            }
        }

        // Haftalara dağıtma
        $week = 1;
        foreach ($matches as $matchData) {
            Game::create([
                'home_team_id' => $matchData['home_team_id'],
                'away_team_id' => $matchData['away_team_id'],
                'week' => $week,
            ]);

            $week++;
            if ($week > 6) {
                $week = 1;
            }
        }
    }
}
