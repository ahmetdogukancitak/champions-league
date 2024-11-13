<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Game;

class PredictionService
{
    public function getChampionshipOdds($simulationCount = 10000)
    {
        $teams = Team::all()->keyBy('id');
        $teamIds = $teams->keys()->toArray();

        // Hafta 4 oynandı mı kontrol et
        $totalWeek4Games = Game::where('week', 4)->count();
        $playedWeek4Games = Game::where('week', 4)
            ->whereNotNull('home_team_score')
            ->whereNotNull('away_team_score')
            ->count();

        if ($playedWeek4Games < $totalWeek4Games) {
            // Hafta 4 henüz tamamlanmadı, tüm olasılıkları %0 olarak ayarla
            $odds = array_fill_keys($teamIds, 0);

            // Takım isimleriyle eşleştir
            $teamOdds = [];
            foreach ($odds as $teamId => $chance) {
                $teamOdds[$teams[$teamId]->name] = $chance;
            }

            return $teamOdds;
        }

        // Hafta 4 tamamlandı, simülasyonları yap
        $odds = array_fill_keys($teamIds, 0);

        // Mevcut puanları al
        $currentPoints = [];
        foreach ($teams as $team) {
            $stats = $team->getLeagueStats();
            $currentPoints[$team->id] = $stats['points'];
        }

        // Simülasyonları yap
        for ($i = 0; $i < $simulationCount; $i++) {
            $simulatedPoints = $currentPoints;

            // Kalan maçları alın
            $remainingGames = Game::whereNull('home_team_score')->get();

            // Kalan maçları simüle et
            foreach ($remainingGames as $game) {
                // Maçı simüle et
                $result = $this->simulateGameResult($teams[$game->home_team_id], $teams[$game->away_team_id]);

                // Puanları ekle
                if ($result == 'home_win') {
                    $simulatedPoints[$game->home_team_id] += 3;
                } elseif ($result == 'away_win') {
                    $simulatedPoints[$game->away_team_id] += 3;
                } else { // Beraberlik
                    $simulatedPoints[$game->home_team_id] += 1;
                    $simulatedPoints[$game->away_team_id] += 1;
                }
            }

            // Şampiyonu belirle
            $maxPoints = max($simulatedPoints);
            $winners = array_keys($simulatedPoints, $maxPoints);

            // Eğer birden fazla takım aynı puanda ise, hepsine 1 say
            foreach ($winners as $winnerId) {
                $odds[$winnerId] += 1 / count($winners);
            }
        }

        // Olasılıkları yüzde olarak hesapla
        foreach ($odds as $teamId => &$count) {
            $count = ($count / $simulationCount) * 100;
        }

        // Takım isimleriyle eşleştir
        $teamOdds = [];
        foreach ($odds as $teamId => $chance) {
            $teamOdds[$teams[$teamId]->name] = $chance;
        }

        return $teamOdds;
    }

    private function simulateGameResult($homeTeam, $awayTeam)
    {
        // Takımların güçlerini al (varsayılan olarak eşit)
        $homeStrength = 1;
        $awayStrength = 1;

        // Rastgele bir sayı üret
        $rand = mt_rand(1, 100);

        // Ev sahibi avantajı ekleyelim
        $homeWinProbability = 40 * $homeStrength;
        $drawProbability = 30;
        $awayWinProbability = 30 * $awayStrength;

        $total = $homeWinProbability + $drawProbability + $awayWinProbability;

        // Olasılıkları normalize et
        $homeWinProbability = ($homeWinProbability / $total) * 100;
        $drawProbability = ($drawProbability / $total) * 100;
        $awayWinProbability = ($awayWinProbability / $total) * 100;

        if ($rand <= $homeWinProbability) {
            return 'home_win';
        } elseif ($rand <= $homeWinProbability + $drawProbability) {
            return 'draw';
        } else {
            return 'away_win';
        }
    }
}
