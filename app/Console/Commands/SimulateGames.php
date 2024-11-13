<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Services\GameSimulator;

class SimulateGames extends Command
{
    protected $signature = 'simulate:games {week?}';

    protected $description = 'Belirtilen haftanın maçlarını simüle eder';

    public function handle()
    {
        $week = $this->argument('week');
    
        $simulator = new GameSimulator();
    
        if ($week && $week != 'all') {
            // Belirli bir haftanın maçlarını simüle et
            $games = Game::where('week', $week)->get();
    
            foreach ($games as $game) {
                if (is_null($game->home_team_score) && is_null($game->away_team_score)) {
                    $simulator->simulate($game);
                    $this->info("{$game->homeTeam->name} {$game->home_team_score} - {$game->away_team_score} {$game->awayTeam->name}");
                }
            }
    
            $this->info("{$week}. hafta maçları simüle edildi.");
        } else {
            // Tüm maçları simüle et
            $games = Game::whereNull('home_team_score')->whereNull('away_team_score')->get();
    
            foreach ($games as $game) {
                $simulator->simulate($game);
                $this->info("{$game->homeTeam->name} {$game->home_team_score} - {$game->away_team_score} {$game->awayTeam->name}");
            }
    
            $this->info("Tüm maçlar simüle edildi.");
        }
    }
    
}
