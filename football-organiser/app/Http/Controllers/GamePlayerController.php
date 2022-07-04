<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Player;
use App\Models\GamePlayer;
use App\Http\Resources\GamePlayerResource;
use DB;

class GamePlayerController extends Controller
{
    public function assignPlayerToGame(Request $request){
        $json = json_decode($request->getContent(),true);
        $playerId = $json['player_id'];
        $gameId = $json['game_id'];

        $game = Game::find($gameId);
        $player = Player::find($playerId);

        $game->players()->attach($player, ['paid' => False, 'team' => 'none']);
    }

    public function setPlayerPaid(Request $request){
        $jsonRaw = $request->getContent();
        $json = json_decode($jsonRaw,true);

        $gameId = $json['game_id'];
        $playerId = $json['player_id'];
       

        $game = Game::find($gameId);
        $player = Player::find($playerId);

        $game->players()->sync([$playerId => ['paid' => TRUE]], false);

        return response()->json(GamePlayer::get());
    }

    public function setPlayerNotPaid(Request $request){
        $jsonRaw = $request->getContent();
        $json = json_decode($jsonRaw,true);

        $gameId = $json['game_id'];
        $playerId = $json['player_id'];

        $game = Game::find($gameId);
        $player = Player::find($playerId);

        $game->players()->sync([$playerId => ['paid' => FALSE]], false);

        return response()->json(GamePlayer::get());
    }

    public function getPaid(Request $request){
        $json = json_decode($request->getContent(),true);

        $gameId = $json['game_id'];
        $playerId = $json['player_id'];
        
        $playersPaid = GamePlayer::where('game_id',$gameId)
                                ->where('player_id',$playerId)
                                ->where('paid',1);

        return response()->json($playerPaid);
    }

    public function getNotPaid(Request $request){
        $json = json_decode($request->getContent(),true);

        $gameId = $json['game_id'];
        $playerId = $json['player_id'];
        
        $playersNotPaid = GamePlayer::where('game_id',$gameId)
                                ->where('player_id',$playerId)
                                ->where('paid',0);

        return response()->json($playerPaid);
    }

    public function assignPlayerToTeam(Request $request){
        $json = json_decode($request->getContent(),true);

        $gameId = $json['game_id'];
        $playerId = $json['player_id'];
        $teamName = $json['team'];

        $team1Name = Game::where('id',$gameId)->value('team_1_name');
        $team2Name = Game::where('id',$gameId)->value('team_2_name');

        if ($teamName === $team1Name || $teamName === $team2Name){

            $game = Game::find($gameId);

            $game->players()->sync([$playerId => ['team' => $teamName]], false);

            return (response()->json(GamePlayer::get()));
        }

        return response()->json(["team" => "invalid"]);
    }

    public function getTeams(Request $request){
        $json = json_decode($request->getContent(),true);
        $gameId = $json['game_id'];

        $game = Game::find($gameId);

        $team1Name = Game::where('id',$gameId)->value('team_1_name');
        $team2Name = Game::where('id',$gameId)->value('team_2_name');

        $team1 = [];
        $team2 = [];

        foreach ($game->players as $gamePlayer){
            if ($gamePlayer->pivot->team === $team1Name){
                array_push($team1,[
                    "first_name" => $gamePlayer->first_name,
                    "surname" => $gamePlayer->surname,
                    "paid" => $gamePlayer->pivot->paid
                ]);
            }
            if ($gamePlayer->pivot->team === $team2Name){
                array_push($team2,[
                    "first_name" => $gamePlayer->first_name,
                    "surname" => $gamePlayer->surname,
                    "paid" => $gamePlayer->pivot->paid
                ]);
            }
        }

        $response = [
            "team_1" => [
                "name" => $team1Name,
                "team_members" => $team1
            ],
            "team_2" => [
                "name" => $team2Name,
                "team_members" => $team2
            ]
        ];

        return response()->json($response);
    }

    public function getPlayersInGame(Request $request){
        $json = json_decode($request->getContent(),true);
        $gameId = $json['game_id'];

        $game = Game::find($gameId);

        $response = [];
        
        foreach ($game->players as $gamePlayer){

            array_push($response,[
                "first_name" => $gamePlayer->first_name,
                "surname" => $gamePlayer->surname,
                "paid" =>  $gamePlayer->pivot->paid,
                "team" => $gamePlayer->pivot->team
            ]);
        }

        return response()->json(["players" => $response]);
    }
}
