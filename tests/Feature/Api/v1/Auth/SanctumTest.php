<?php

namespace Tests\Feature\Api\v1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SanctumTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_authenticate()
    {
        $user = User::factory()->create();
        $response = $this->post(route('v1.auth.login', [
            'email' => $user->email,
            'password' => 'password'
        ]));
        $this->assertAuthenticated();
        $response->assertOk();
    }
}
