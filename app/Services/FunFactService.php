<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FunFactService
{
    public static function getFunFact(): string
    {
        try {
            $response = Http::withHeader('X-Api-Key', config('services.funfacts.key'))
                ->get(config('services.funfacts.endpoint'));
            return $response->json()[0]['fact'];
        } catch (\Exception $e) {
            return 'No fun fact available';
        }
    }
}
