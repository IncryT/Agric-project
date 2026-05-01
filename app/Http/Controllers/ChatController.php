<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\MarketPrice;
use App\Models\Product;

class ChatController extends Controller
{
    public function respond(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = trim($request->input('message'));
        $geminiKey = env('GEMINI_API_KEY') ?: env('GEMINI_KEY');
        $openAiKey = env('OPENAI_API_KEY') ?: env('OPENAI_KEY');

        // Get authenticated user context
        $user = $request->user();
        $userName = $user ? $user->name : 'Farmer';
        $userDistrict = $user && $user->district ? $user->district : 'your area';

        Log::info('Chat respond called', [
            'user' => $userName,
            'district' => $userDistrict,
            'gemini_key_present' => !empty($geminiKey),
            'openai_key_present' => !empty($openAiKey),
            'message' => $message
        ]);

        $reply = '';
        if ($geminiKey) {
            Log::info('Trying Gemini API');
            $reply = $this->getGeminiReply($message, $geminiKey, $userName, $userDistrict);
        }
        if (empty($reply) && $openAiKey) {
            Log::info('Trying OpenAI API');
            $reply = $this->getOpenAiReply($message, $openAiKey, $userName, $userDistrict);
        }
        if (empty($reply)) {
            Log::info('Using fallback');
            $reply = $this->fallbackReply($message, $userName, $userDistrict);
        }

        Log::info('Chat reply generated', ['reply_length' => strlen($reply), 'reply_preview' => substr($reply, 0, 100)]);

        return response()->json(['reply' => $reply]);
    }

    private function getGeminiReply(string $message, string $apiKey, string $userName, string $userDistrict): string
    {
        $currentYear = date('Y');
        $systemPrompt = "You are an agricultural market advisor helping farmers in Zimbabwe with current crop prices, market trends, and selling recommendations. The current year is {$currentYear}. The farmer's name is {$userName} and they are located in {$userDistrict}. Provide detailed and helpful responses specific to Zimbabwe markets and their local area. Address them by name when appropriate. IMPORTANT: Do NOT mention specific past years (2023, 2024, 2025) or previous seasons. Focus only on current market conditions. If you don't have specific price data, say 'I don't have that current data' rather than making up numbers or citing old seasons.";

        $payload = json_encode([
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        [
                            'text' => $systemPrompt . ' ' . $message
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.6,
                'maxOutputTokens' => 1000,
            ]
        ]);

        $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=' . $apiKey;

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        if (app()->environment('local') || env('OPENAI_DISABLE_SSL_VERIFICATION') === 'true') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if (!$response || $error || $status >= 400) {
            Log::error('Gemini request failed', [
                'status' => $status,
                'error' => $error,
                'response' => $response,
            ]);

            return '';
        }

        $data = json_decode($response, true);
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        return trim($reply) ?: '';
    }

    private function getOpenAiReply(string $message, string $apiKey, string $userName, string $userDistrict): string
    {
        $currentYear = date('Y');
        $payload = json_encode([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are an agricultural market advisor helping farmers in Zimbabwe with current crop prices, market trends, and selling recommendations. The current year is {$currentYear}. The farmer's name is {$userName} and they are located in {$userDistrict}. Provide detailed and helpful responses specific to Zimbabwe markets and their local area. Address them by name when appropriate. IMPORTANT: Do NOT mention specific past years (2023, 2024, 2025) or previous seasons. Focus only on current market conditions. If you don't have specific price data, say 'I don't have that current data' rather than making up numbers or citing old seasons."
                ],
                [
                    'role' => 'user',
                    'content' => $message
                ],
            ],
            'temperature' => 0.6,
            'max_tokens' => 1000,
        ]);

        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        if (app()->environment('local') || env('OPENAI_DISABLE_SSL_VERIFICATION') === 'true') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if (!$response || $error || $status >= 400) {
            Log::error('OpenAI request failed', [
                'status' => $status,
                'error' => $error,
                'response' => $response,
            ]);
            return '';
        }

        $data = json_decode($response, true);
        $reply = $data['choices'][0]['message']['content'] ?? null;

        return trim($reply) ?: '';
    }

    private function fallbackReply(string $message, string $userName, string $userDistrict): string
    {
        Log::info('Chat fallback triggered', ['message' => $message]);
        $lower = strtolower($message);

        // Extract potential crop keywords from message
        $keywords = preg_split('/\s+/', $lower);
        $keywords = array_filter($keywords, function($word) {
            return strlen($word) > 3 && !in_array($word, ['price', 'prices', 'market', 'about', 'what']);
        });

        $allPrices = $this->getAllLatestPrices();
        Log::info('Fallback prices loaded', ['prices_count' => count($allPrices)]);

        // Find matching crops (fuzzy match)
        $matches = [];
        foreach ($allPrices as $crop => $data) {
            foreach ($keywords as $keyword) {
                if (stripos($crop, $keyword) !== false || stripos($keyword, $crop) !== false) {
                    $matches[$crop] = $data;
                    break;
                }
            }
        }

        $currentYear = date('Y');

        if (!empty($matches)) {
            if (count($matches) === 1) {
                $crop = array_key_first($matches);
                $price = $matches[$crop]['price'];
                $unit = $matches[$crop]['unit'];
                $date = $matches[$crop]['date'];
                return "Hello {$userName}! According to our latest scraped data from ZimPriceCheck (as of {$date}), **{$crop}** is currently **$" . number_format($price, 2) . "** per {$unit}. This data is from Mbare Market prices for the {$currentYear} season.";
            } else {
                $formatted = collect($matches)->map(function ($data, $crop) {
                    return ucfirst($crop) . ': $' . number_format($data['price'], 2);
                })->implode(', ');
                return "Hi {$userName}, I found these matching crops from current ZimPriceCheck data: {$formatted}. Which one would you like details for?";
            }
        }

        // General market summary (top 10)
        if (!empty($allPrices)) {
            $topCrops = array_slice($allPrices, 0, 10, true);
            $formatted = collect($topCrops)->map(function ($data, $crop) {
                return ucfirst($crop) . ': $' . number_format($data['price'], 2);
            })->implode(', ');
            return "Hello {$userName}! Here are current ZimPriceCheck market prices for {$currentYear}: {$formatted}. These are updated daily from Mbare Market. Ask about a specific crop for details!";
        }

        // No data available
        if (stripos($message, 'hello') !== false || stripos($message, 'hi') !== false) {
            return "Hello {$userName}! 🌾 I'm your agricultural market advisor. I'm sorry, but I don't have current scraped market data available at the moment. The daily price scraper from ZimPriceCheck.com may not have run yet. Please try again later or check manually at Mbare Market.";
        }

        return "I'm sorry {$userName}, I don't have current market price data available right now. The ZimPriceCheck scraper updates daily at 6:00 AM with fresh Mbare Market prices. Please try again later or visit Mbare Musika directly for the latest rates.";
    }

    private function getAllLatestPrices(): array
    {
        // Fetch latest prices from database (scraped daily from ZimPriceCheck)
        $products = Product::with(['marketPrices' => function ($query) {
            $query->latest('date')->limit(1);
        }])->has('marketPrices')->get();

        $prices = [];
        foreach ($products as $product) {
            $latestPrice = $product->marketPrices->first();
            if ($latestPrice) {
                $prices[strtolower($product->name)] = [
                    'price' => $latestPrice->price,
                    'unit' => $product->unit_of_measure,
                    'date' => $latestPrice->date
                ];
            }
        }

        // Return empty array if no scraped data available
        return $prices;
    }

    private function getLatestPrice($productName)
    {
        $product = Product::whereRaw('LOWER(name) LIKE ?', ["%$productName%"])->first();
        return $product?->marketPrices()->latest('date')->first()?->price;
    }
}
