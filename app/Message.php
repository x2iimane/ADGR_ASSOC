<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function donneur(){
        return $this->belongsTo(Donneur::class, "donneur_id", "id");
    }

    public function benevole(){
        return $this->belongsTo(Benevole::class, "benevole_id", "id");
    }
}
