<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private string $email = '19nikolai9223@gmail.com';

    /**
     * A basic feature test example.
     */
    public function test_register(): void
    {
        $data = [
            'name' => 'Vasya',
            'email' => $this->email,
            'password' => '12345678',
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(200);
    }
    public function test_login(): void
    {
        $response = $this->login();

        $response->assertStatus(200);
    }

    public function test_logout(): void
    {
        $data = [
            'email' => $this->email,
        ];
        $response = $this->post('/api/logout', $data);
        $response->assertStatus(200);
    }

    private function login()
    {
        $data = [
            'email' => $this->email,
            'password' => '12345678',
        ];

        return $this->post('/api/login', $data);
    }
}
