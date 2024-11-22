<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Abstract\Translatable;

class Category extends Translatable
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
}
