<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GamePlayerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/GetPlayers',[PlayerController::class,'getPlayers']);

Route::post('/AddPlayer',[PlayerController::class,'addPlayer']);

Route::delete('/RemovePlayer',[PlayerController::class,'removeGame']);

Route::get('/GetGames',[GameController::class,'getGames']);

Route::post('/AddGame',[GameController::class,'addGame']);

Route::delete('/RemoveGame',[GameController::class,'removeGame']);

Route::patch('/SetPaid',[GamePlayerController::class,'setPlayerPaid']);

Route::patch('/SetNotPaid',[GamePlayerController::class,'setPlayerNotPaid']);

Route::post('/SetPlayerToGame',[GamePlayerController::class,'assignPlayerToGame']);

Route::patch('/SetPlayerToTeam',[GamePlayerController::class,'assignPlayerToTeam']);

Route::get('/GetTeams',[GamePlayerController::class,'getTeams']);

Route::get('/GetPlayersInGame',[GamePlayerController::class,'getPlayersInGame']);
