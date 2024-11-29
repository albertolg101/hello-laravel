<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('localized_texts', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->morphs('translatable');
            $table->boolean('is_default')->nullable()->default(null);
            $table->timestamps();

            $table->unique(
                ['language_id', 'translatable_id', 'translatable_type'],
                'unique_language_translatable'
            );
            $table->unique(
                ['is_default', 'translatable_id', 'translatable_type'],
                'unique_default_translatable'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localized_texts');
    }
};
