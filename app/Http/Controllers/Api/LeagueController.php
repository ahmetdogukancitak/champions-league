<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Game;
use App\Services\GameSimulator;
use App\Services\PredictionService;
use App\Services\FixtureGenerator;

class LeagueController extends Controller
{
    public function getLeagueTable()
    {
        $teams = Team::all();
        $leagueTable = [];

        foreach ($teams as $team) {
            $leagueTable[] = $team->getLeagueStats();
        }

        // Puan ve averaja göre sıralama
        usort($leagueTable, function ($a, $b) {
            if ($b['points'] == $a['points']) {
                return $b['goal_difference'] <=> $a['goal_difference'];
            }
            return $b['points'] <=> $a['points'];
        });

        return response()->json($leagueTable);
    }

    public function getGames()
    {
        $games = Game::with(['homeTeam', 'awayTeam'])->get();
        return response()->json($games);
    }

    public function simulateWeek(Request $request)
    {
        $week = $request->input('week');
        $games = Game::where('week', $week)->get();

        $simulator = new GameSimulator();

        foreach ($games as $game) {
            if (is_null($game->home_team_score) && is_null($game->away_team_score)) {
                $simulator->simulate($game);
            }
        }

        return response()->json(['message' => "{$week}. hafta maçları simüle edildi."]);
    }

    public function simulateAll()
    {
        $games = Game::whereNull('home_team_score')->get();

        $simulator = new GameSimulator();

        foreach ($games as $game) {
            $simulator->simulate($game);
        }

        return response()->json(['message' => 'Tüm maçlar simüle edildi.']);
    }

    public function getPredictions()
    {
        $predictionService = new PredictionService();
        $odds = $predictionService->getChampionshipOdds();

        return response()->json($odds);
    }

    public function updateGame(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->home_team_score = $request->input('home_team_score');
        $game->away_team_score = $request->input('away_team_score');
        $game->save();

        return response()->json(['message' => 'Maç sonucu güncellendi.']);
    }

    public function resetFixtures()
{
    // Mevcut maçları sil
    Game::truncate();

    // Fikstürü yeniden oluştur
    $generator = new FixtureGenerator();
    $generator->generate();

    return response()->json(['message' => 'Fikstür sıfırlandı ve yeniden oluşturuldu.']);
}



}

