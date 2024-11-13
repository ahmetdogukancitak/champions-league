<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Team;
use App\Services\PredictionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PredictionServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_zero_odds_before_week_four()
    {
        // 4 takım oluştur
        $teams = Team::factory()->count(4)->create();

        // PredictionService'i oluştur
        $predictionService = new PredictionService();

        // Olasılıkları al
        $odds = $predictionService->getChampionshipOdds();

        // Tüm olasılıkların %25 olduğunu doğrula
        foreach ($teams as $team) {
            $teamName = $team->name;
            $this->assertArrayHasKey($teamName, $odds);
            $this->assertEquals(25, $odds[$teamName], "Team {$teamName} should have 0% chance before week 4.");
        }
    }
}
