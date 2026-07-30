<?php
namespace Mega\SallaVoiceAI\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Mega\SallaVoiceAI\Models\Product;

class SyncProductsJob implements ShouldQueue
{
    protected $store;

    public function __construct($store)
    {
        $this->store = $store;
    }

    public function handle()
    {
        $products = Http::withToken($this->store->access_token)
            ->get('https://api.salla.dev/admin/v2/products')
            ->json()['data'];

        foreach ($products as $p) {
            Product::updateOrCreate(
                [
                    'salla_product_id' => $p['id'],
                    'store_id' => $this->store->id
                ],
                [
                    'name' => $p['name'],
                    'price' => $p['price'],
                    'image' => $p['images'][0]['url'] ?? null,
                    'product_url' => $p['url']
                ]
            );
        }
    }
}