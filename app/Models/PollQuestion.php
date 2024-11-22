<?php

namespace App\Models;

use App\Models\Abstract\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PollQuestion extends Translatable
{
    /** @use HasFactory<\Database\Factories\PollQuestionFactory> */
    use HasFactory;
}
