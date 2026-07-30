<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InstallationController extends Controller
{
   public function redirect(Request $request)
    {
        $queryParams = [
            'client_id' => 5578, 
            'redirect_uri' => 'https://limra-softwares.com/callback', 
            'response_type' => 'code',
        ];
        $queries = http_build_query($queryParams);
        return redirect('https://oauth.zid.sa'.'/oauth/authorize?'.$queries);
    }

    public function callback(Request $request)
    {
        try {
            
            $params = [
                'grant_type' => 'authorization_code',
                'client_id' => '5578', 
                'client_secret' => 'CaD7bHSoLzncj0dzx3n8kPCVDqxKNzcre8GpaFx4', 
                'redirect_uri' => 'https://limra-softwares.com/callback', 
                'code' => $request->code, // grant code
            ];
            $response = Http::post('https://oauth.zid.sa'.'/oauth/token', $params);

            $responseData = $response->json();
            return;

        } catch (\Exception $e) {

        }

    }
    
    public function index(Request $request): JsonResponse
    {
        $event = $request->event;
         return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }
    
    
    public function store(Request $request)
    {
        // Log all incoming data (for debugging)
        Log::info('Checkout Custom Data Received', [
            'note' => $request->input('note'),
            'has_image' => $request->hasFile('image'),
        ]);
        
         Log::info('Checkout Request Data', [
            'data' => $request->all(),
         ]);

        $note = $request->input('note');
        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(
                'checkout-images',
                'public'
            );
        }

        // Example: save to database (optional)
        /*
        CheckoutMeta::create([
            'note' => $note,
            'image_path' => $imagePath,
        ]);
        */

        return response()->json([
            'success' => true,
            'message' => 'Checkout data saved successfully',
            'data' => [
                'note' => $note,
                'image_path' => $imagePath,
            ]
        ]);
    }

}
