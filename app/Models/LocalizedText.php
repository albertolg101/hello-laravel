<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocalizedText extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'language_id',
        'is_default',
    ];

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}
