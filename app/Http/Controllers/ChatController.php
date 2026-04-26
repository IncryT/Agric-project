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

        Log::info('Chat respond called', [
            'gemini_key_present' => !empty($geminiKey),
            'openai_key_present' => !empty($openAiKey),
            'message' => $message
        ]);

        if ($geminiKey) {
            Log::info('Using Gemini API');
            $reply = $this->getGeminiReply($message, $geminiKey);
        } elseif ($openAiKey) {
            Log::info('Using OpenAI API');
            $reply = $this->getOpenAiReply($message, $openAiKey);
        } else {
            Log::info('Using fallback (no API keys)');
            $reply = $this->fallbackReply($message);
        }

        Log::info('Chat reply generated', ['reply_length' => strlen($reply), 'reply_preview' => substr($reply, 0, 100)]);

        return response()->json(['reply' => $reply]);
    }

    private function getGeminiReply(string $message, string $apiKey): string
    {
        $payload = json_encode([
            'messages' => [
                ['author' => 'system', 'content' => [['type' => 'text', 'text' => 'You are an agricultural market advisor helping farmers with current crop prices, market trends, and selling recommendations. Answer clearly and concisely.']]],
                ['author' => 'user', 'content' => [['type' => 'text', 'text' => $message]]],
            ],
            'temperature' => 0.6,
            'max_output_tokens' => 250,
        ]);

        $endpoint = 'https://gemini.googleapis.com/v1/models/gemini-1.5-turbo:generateMessage';

        $ch = curl_init($endpoint);
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
            Log::error('Gemini request failed', [
                'status' => $status,
                'error' => $error,
                'response' => $response,
            ]);

            return $this->fallbackReply($message);
        }

        $data = json_decode($response, true);
        $reply = $data['candidates'][0]['content'][0]['text'] ?? null;

        return trim($reply ?? $this->fallbackReply($message));
    }

    private function getOpenAiReply(string $message, string $apiKey): string
    {
        $payload = json_encode([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an agricultural market advisor helping farmers with current crop prices, market trends, and selling recommendations. Answer clearly and concisely. Use real market data when possible.'
                ],
                [
                    'role' => 'user',
                    'content' => $message
                ],
            ],
            'temperature' => 0.6,
            'max_tokens' => 250,
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
            return $this->fallbackReply($message);
        }

        $data = json_decode($response, true);
        $reply = $data['choices'][0]['message']['content'] ?? null;

        return trim($reply ?? $this->fallbackReply($message));
    }

    private function fallbackReply(string $message): string
    {
        Log::info('Chat fallback triggered', ['message' => $message]);
        $lower = strtolower($message);

        // Extract potential crop keywords from message (simple: words after 'about', 'price', or main words)
        $keywords = preg_split('/\s+/', $lower);
        $keywords = array_filter($keywords, function($word) {
            return strlen($word) > 3 && !in_array($word, ['price', 'prices', 'market', 'about', 'what']);
        });

        $allPrices = $this->getAllLatestPrices();
        Log::info('Fallback prices loaded', ['prices_count' => count($allPrices)]);

        // Find matching crops (fuzzy: crop name contains keyword)
        $matches = [];
        foreach ($allPrices as $crop => $price) {
            foreach ($keywords as $keyword) {
                if (stripos($crop, $keyword) !== false || stripos($keyword, $crop) !== false) {
                    $matches[$crop] = $price;
                    break;
                }
            }
        }

        if (!empty($matches)) {
            // Prefer single match, or top 3 if multiple
            if (count($matches) === 1) {
                [$crop, $price] = each($matches);
                return ucfirst($crop) . " is currently **$" . number_format($price, 2) . "** per unit. Check local market conditions before selling.";
            } else {
                $formatted = collect($matches)->map(function ($price, $crop) {
                    return ucfirst($crop) . ': $' . number_format($price, 2);
                })->implode(', ');
                return "Matching crops: {$formatted}. Which one?";
            }
        }

        // General market summary (limit to first 10 for brevity)
        if (!empty($allPrices)) {
            $limited = array_slice($allPrices, 0, 10, true);
            $formatted = collect($limited)->map(function ($price, $crop) {
                return ucfirst($crop) . ': $' . number_format($price, 2);
            })->implode(', ');
            return "Top market prices: {$formatted}... Name a specific crop for details!";
        }

        // Generic greetings/market queries
        if (stripos($message, 'hello') !== false || stripos($message, 'hi') !== false) {
            return "Hello! 🌾 I'm your market advisor with live system data. Ask about any crop like 'maize price' or 'soybeans'!";
        }

        if (stripos($message, 'price') !== false || stripos($message, 'market') !== false) {
            return "Live crop prices from our system. Try 'maize', 'soybeans', 'wheat price' for specific info!";
        }

        return "I can provide current crop prices from our system. Try mentioning a crop name like 'maize' or 'soybeans'!";
    }

    private function getAllLatestPrices(): array
    {
        $prices = [];
        $products = Product::whereHas('marketPrices')->get();
        
        foreach ($products as $product) {
            $latestPrice = $product->marketPrices()->latest('date')->first();
            if ($latestPrice) {
                $prices[strtolower($product->name)] = $latestPrice->price;
            }
        }
        
        // Fallback static if no DB data
        if (empty($prices)) {
            return [
                'wheat' => 240.50,
                'corn' => 185.20,
                'soybean' => 410.00,
                'rice' => 320.15,
            ];
        }
        
        return $prices;
    }

    private function getLatestPrice($productName)
    {
        $product = Product::whereRaw('LOWER(name) LIKE ?', ["%$productName%"])->first();
        return $product?->marketPrices()->latest('date')->first()?->price;
    }
}
