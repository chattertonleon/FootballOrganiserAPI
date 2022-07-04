<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name','surname','team'
    ];

    public function games(){
        return $this->belongsToMany(Game::class,'game_players')
                    ->withPivot('paid','team')
                    ->withTimeStamps();
    }
}
