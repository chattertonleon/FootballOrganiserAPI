<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    //
    public function getPlayers(){
        $players = Player::all();
        return response()->json($players);
    }

    public function addPlayer(Request $request){
        $jsonRaw = $request->getContent();
        $json = json_decode($jsonRaw,true);

        $first_name = $json['first_name'];
        $surname = $json['surname'];

        $player = new Player;
        $player->first_name = $first_name;
        $player->surname = $surname;
        $player->save();

        return response()->json(Player::all());
    }
}
