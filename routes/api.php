<?php
use App\Http\Controllers\Api\LeagueController;
use Illuminate\Support\Facades\Route;

Route::get('/league-table', [LeagueController::class, 'getLeagueTable']);
Route::get('/games', [LeagueController::class, 'getGames']);
Route::post('/simulate-week', [LeagueController::class, 'simulateWeek']);
Route::post('/simulate-all', [LeagueController::class, 'simulateAll']);
Route::get('/predictions', [LeagueController::class, 'getPredictions']);
Route::put('/games/{id}', [LeagueController::class, 'updateGame']);
Route::post('/reset-fixtures', [LeagueController::class, 'resetFixtures']);
