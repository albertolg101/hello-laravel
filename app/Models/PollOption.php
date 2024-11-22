<?php

namespace App\Models;

use App\Models\Abstract\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PollOption extends Translatable
{
    /** @use HasFactory<\Database\Factories\PollOptionFactory> */
    use HasFactory;

    function votes()
    {
        return $this->hasMany(PollVote::class);
    }
}
