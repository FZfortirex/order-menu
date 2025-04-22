<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    public function tukarPoin()
{
    return $this->hasMany(TukarPoin::class);
}

}
