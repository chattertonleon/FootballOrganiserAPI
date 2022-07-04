<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'date','kick_off','finish_time','team_1_name','team_2_name','price_per_player'
    ];

    public function players(){
        return $this->belongsToMany(Player::class,'game_players')
                    ->withPivot('paid','team')
                    ->withTimeStamps();
    }
}
