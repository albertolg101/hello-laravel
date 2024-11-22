<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    /** @use HasFactory<\Database\Factories\PollFactory> */
    use HasFactory;

    public function question()
    {
        return $this->hasOne(PollQuestion::class);
    }

    public function options()
    {
        return $this->hasMany(PollOption::class);
    }
}
