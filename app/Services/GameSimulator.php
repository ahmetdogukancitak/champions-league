<?php

namespace App\Services;

use App\Models\Game;

class GameSimulator
{
    public function simulate(Game $game)
    {
        $homeTeam = $game->homeTeam;
        $awayTeam = $game->awayTeam;

        // Takım güçlerini al
        $homeStrength = $homeTeam->strength + rand(0, 10); // Ev sahibi avantajı için rastgele bir değer ekliyoruz
        $awayStrength = $awayTeam->strength + rand(0, 5);

        // Gol sayısını hesapla
        $homeGoals = $this->calculateGoals($homeStrength, $awayStrength);
        $awayGoals = $this->calculateGoals($awayStrength, $homeStrength);

        // Maç sonucunu kaydet
        $game->home_team_score = $homeGoals;
        $game->away_team_score = $awayGoals;
        $game->save();
    }

    private function calculateGoals($attackStrength, $defenseStrength)
    {
        // Gol olasılığını hesapla
        $goalProbability = $attackStrength / ($attackStrength + $defenseStrength);
        $goals = 0;

        // Her takım için maksimum 5 gol olabilir
        for ($i = 0; $i < 5; $i++) {
            if (rand(0, 100) < ($goalProbability * 100)) {
                $goals++;
            }
        }

        return $goals;
    }
}
