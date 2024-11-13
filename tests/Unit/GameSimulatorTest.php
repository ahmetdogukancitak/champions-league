<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Team;
use App\Models\Game;
use App\Services\GameSimulator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameSimulatorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_simulates_a_game_and_updates_scores()
    {
        // Takımları oluştur
        $homeTeam = Team::factory()->create(['strength' => 90]);
        $awayTeam = Team::factory()->create(['strength' => 80]);

        // Maçı oluştur
        $game = Game::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'week' => 1,
        ]);

        // GameSimulator'ı kullanarak maçı simüle et
        $simulator = new GameSimulator();
        $simulator->simulate($game);

        // Veritabanından güncellenmiş maçı al
        $game = $game->fresh();

        // Skorların güncellendiğini kontrol et
        $this->assertNotNull($game->home_team_score, 'Home team score should not be null after simulation.');
        $this->assertNotNull($game->away_team_score, 'Away team score should not be null after simulation.');

        // Skorların geçerli aralıkta olduğunu kontrol et (örneğin, 0 ile 10 arasında)
        $this->assertGreaterThanOrEqual(0, $game->home_team_score, 'Home team score should be at least 0.');
        $this->assertLessThanOrEqual(10, $game->home_team_score, 'Home team score should be at most 10.');

        $this->assertGreaterThanOrEqual(0, $game->away_team_score, 'Away team score should be at least 0.');
        $this->assertLessThanOrEqual(10, $game->away_team_score, 'Away team score should be at most 10.');
    }
}
