<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Http\CurlClient;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');

        if (empty($sid) || empty($token) || empty($from)) {
            throw new \RuntimeException('Twilio configuration is incomplete. Please set TWILIO_SID, TWILIO_AUTH_TOKEN and TWILIO_PHONE_NUMBER.');
        }

        $curlOptions = $this->getCurlOptions();
        $curlClient = new CurlClient($curlOptions);
        $this->client = new Client($sid, $token, null, null, $curlClient);
        $this->from = $this->normalizePhoneNumber($from);

        if (! $this->isValidPhoneNumber($this->from)) {
            throw new \RuntimeException('Twilio from number is invalid. Please set TWILIO_PHONE_NUMBER in E.164 format.');
        }
    }

    /**
     * Send an SMS message using Twilio.
     *
     * @param string $to PhoneNumber (e.g., +27821234567)
     * @param string $message The SMS body
     * @return bool
     */
    public function sendSms(string $to, string $message): bool
    {
        $originalTo = $to;
        $to = $this->normalizePhoneNumber($to);

        if (! $this->isValidPhoneNumber($to)) {
            Log::warning("SMS skipped: Invalid recipient phone number '{$originalTo}' (normalized to '{$to}')");
            return false;
        }

        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);

            Log::info("SMS sent successfully to {$to}");
            return true;
        } catch (\Throwable $e) {
            $errorMsg = $e->getMessage();
            Log::error("Twilio SMS failed to send to {$originalTo} (normalized: {$to}). Error: {$errorMsg}", [
                'from' => $this->from,
                'message_preview' => mb_substr($message, 0, 160),
                'twilio_error' => $errorMsg,
            ]);

            // Check if account is in trial mode
            if (str_contains($errorMsg, 'trial') || str_contains($errorMsg, 'verify') || str_contains($errorMsg, 'Invalid')) {
                \Log::warning('Tip: Your Twilio account may be in trial mode. Verify phone numbers in Twilio console or upgrade account.');
            }

            return false;
        }
    }

    protected function normalizePhoneNumber(string $phone): string
    {
        if (empty($phone)) {
            return $phone;
        }

        // Remove all non-digit characters except +
        $clean = preg_replace('/[^\d+]/', '', $phone);

        // If already has +, validate it's in correct E.164 format
        if (str_starts_with($clean, '+')) {
            return '+' . ltrim($clean, '+');
        }

        // Convert Zimbabwe numbers: local format 07xxxxxx -> +2637xxxxxx
        // Also handle 0xx numbers for landlines
        if (str_starts_with($clean, '0')) {
            $withoutZero = ltrim($clean, '0');
            // Check if it starts with 7 (mobile) or other (landline)
            if (str_starts_with($withoutZero, '7') || str_starts_with($withoutZero, '8') || str_starts_with($withoutZero, '9')) {
                // Mobile number: 0XXXXXXXX -> +263XXXXXXXX
                return '+263' . $withoutZero;
            } else {
                // Landline: keep 0 prefix after country code (0XX -> +2630XX)
                return '+263' . $clean;
            }
        }

        // If it doesn't start with 0 or +, assume it's missing country code
        // Most likely a mobile number starting with 7, 8, 9
        if (str_starts_with($clean, '7') || str_starts_with($clean, '8') || str_starts_with($clean, '9')) {
            return '+263' . $clean;
        }

        // Fallback: just add +
        return '+' . $clean;
    }

    protected function getCurlOptions(): array
    {
        $options = [
            CURLOPT_SSL_VERIFYPEER => true,
        ];

        $caInfo = env('TWILIO_CURL_CAINFO') ?: $this->findCaBundle();
        if ($caInfo && file_exists($caInfo)) {
            $options[CURLOPT_CAINFO] = $caInfo;
        }

        return $options;
    }

    protected function findCaBundle(): ?string
    {
        $paths = [
            __DIR__ . '/../../certs/cacert.pem',
            'C:/Program Files/Git/mingw64/etc/ssl/certs/ca-bundle.crt',
            'C:/Program Files/Git/usr/ssl/certs/ca-bundle.crt',
            'C:/Program Files/Git/usr/share/pki/ca-trust-source/ca-bundle.trust.crt',
            'C:/Program Files/Git/mingw64/etc/pki/ca-trust/extracted/pem/tls-ca-bundle.pem',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    protected function isValidPhoneNumber(string $phone): bool
    {
        return (bool) preg_match('/^\+[1-9]\d{9,14}$/', $phone);
    }
}
