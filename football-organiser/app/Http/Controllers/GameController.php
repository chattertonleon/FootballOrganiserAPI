<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PlayerController;
use App\Models\Game;
use DateTime;

class GameController extends Controller
{
    //
    public function getGames(){
        $games = Game::all();
        return response()->json($games);
    }

    public function addGame(Request $request){
        $jsonRaw = $request->getContent();
        $json = json_decode($jsonRaw,true);

        $game = new Game;
        $game->date = DateTime::createFromFormat('Y-m-d',$json['date']);
        $game->kick_off = DateTime::createFromFormat('H:i',$json['kick_off']);
        $game->finish_time = DateTime::createFromFormat('H:i',$json['finish_time']);
        $game->team_1_name = $json['team_1_name'];
        $game->team_2_name = $json['team_2_name'];
        $game->price_per_player = number_format($json['price_per_player'],2);
        $game->players_per_team = intval($json['players_per_team']);

        $game->save();

        return response()->json(Game::get());
    }
}
