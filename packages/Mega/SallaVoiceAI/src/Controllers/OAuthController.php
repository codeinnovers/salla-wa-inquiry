<?php
namespace Mega\SallaVoiceAI\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mega\SallaVoiceAI\Models\Store;
use Mega\SallaVoiceAI\Jobs\SyncProductsJob;

class OAuthController
{
    public function install()
    {
        return redirect("https://accounts.salla.sa/oauth2/auth?client_id="
            .config('salla-ai.salla_client_id')
            ."&response_type=code&redirect_uri=".url('/callback'));
    }

    public function callback(Request $request)
    {
        $res = Http::post('https://accounts.salla.sa/oauth2/token', [
            'client_id' => config('salla-ai.salla_client_id'),
            'client_secret' => config('salla-ai.salla_client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => url('/callback'),
        ]);

        $data = $res->json();

        $store = Store::updateOrCreate(
            ['salla_store_id' => $data['merchant']],
            ['access_token' => $data['access_token']]
        );

        dispatch(new SyncProductsJob($store));

        return "Installed Successfully";
    }
}