<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationWithExtendedFieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register_with_extended_fields(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Farmer',
            'email' => 'farmer@example.com',
            'phone' => '+263771234567',
            'district' => 'Mutoko',
            'latitude' => '-17.3897',
            'longitude' => '32.2264',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }
}