<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'strength'];

    public function homeGames()
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayGames()
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    public function getLeagueStats()
    {
        $played = 0;
        $won = 0;
        $drawn = 0;
        $lost = 0;
        $goalsFor = 0;
        $goalsAgainst = 0;
        $points = 0;
    
        $games = Game::where(function($query) {
            $query->where('home_team_id', $this->id)
                  ->orWhere('away_team_id', $this->id);
        })->whereNotNull('home_team_score')->get();
    
        foreach ($games as $game) {
            if ($game->home_team_id == $this->id) {
                // Ev sahibi takım olarak oynadığı maçlar
                $played++;
                $goalsFor += $game->home_team_score;
                $goalsAgainst += $game->away_team_score;
    
                if ($game->home_team_score > $game->away_team_score) {
                    $won++;
                    $points += 3;
                } elseif ($game->home_team_score == $game->away_team_score) {
                    $drawn++;
                    $points += 1;
                } else {
                    $lost++;
                }
            } elseif ($game->away_team_id == $this->id) {
                // Deplasman takımı olarak oynadığı maçlar
                $played++;
                $goalsFor += $game->away_team_score;
                $goalsAgainst += $game->home_team_score;
    
                if ($game->away_team_score > $game->home_team_score) {
                    $won++;
                    $points += 3;
                } elseif ($game->away_team_score == $game->home_team_score) {
                    $drawn++;
                    $points += 1;
                } else {
                    $lost++;
                }
            }
        }
    
        return [
            'team_id' => $this->id,
            'team_name' => $this->name,
            'played' => $played,
            'won' => $won,
            'drawn' => $drawn,
            'lost' => $lost,
            'goals_for' => $goalsFor,
            'goals_against' => $goalsAgainst,
            'goal_difference' => $goalsFor - $goalsAgainst,
            'points' => $points,
        ];
    }
    

}
