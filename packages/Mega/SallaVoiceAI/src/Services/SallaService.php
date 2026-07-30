<?php
namespace App\Modules\SallaVoiceAI\Services;

use Illuminate\Support\Facades\Http;

class SallaService
{
    public function getProducts($token)
    {
        return Http::withToken($token)
            ->get('https://api.salla.dev/admin/v2/products')
            ->json()['data'];
    }
}