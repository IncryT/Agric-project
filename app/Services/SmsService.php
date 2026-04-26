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
        $to = $this->normalizePhoneNumber($to);

        if (! $this->isValidPhoneNumber($to)) {
            Log::error("Twilio SMS Failed: invalid recipient phone number '{$to}'.");
            return false;
        }

        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::error("Twilio SMS failed to send to {$to}. Error: " . $e->getMessage(), [
                'from' => $this->from,
                'message' => mb_substr($message, 0, 160),
            ]);

            return false;
        }
    }

    protected function normalizePhoneNumber(string $phone): string
    {
        if (empty($phone)) {
            return $phone;
        }

        $clean = preg_replace('/[^\d+]/', '', $phone);

        if (str_starts_with($clean, '+')) {
            return '+' . ltrim($clean, '+');
        }

        return '+' . ltrim($clean, '0');
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
