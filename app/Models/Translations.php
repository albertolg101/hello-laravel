<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translations extends Model
{
    /** @use HasFactory<\Database\Factories\TranslationsFactory> */
    use HasFactory;

    protected $fillable = [
        'default_localized_text_id',
    ];

    public function defaultLocalizedText()
    {
        return $this->hasOne(LocalizedText::class, 'id', 'default_localized_text_id');
    }

    public function localizedTexts()
    {
        return $this->hasMany(LocalizedText::class );
    }

    public function translatable()
    {
        return $this->morphTo();
    }
}
