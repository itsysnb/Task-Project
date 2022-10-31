<?php

namespace Tests\Feature\Api\v1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SanctumTest extends TestCase
{
    use RefreshDatabase;
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

    public function test_new_user_can_register()
    {
        $this->postJson(route('v1.auth.register'),[
            'first_name' => 'jack',
            'last_name' => 'jackson',
            'email' => 'jackson@gmail.com',
            'password' => 'jack6070!A',
            'password_confirmation' => 'jack6070!A'
        ])->assertCreated();
        $this->assertDatabaseHas('users', ['first_name' => 'jack']);
    }

    public function test_user_can_login()
    {
        $response = $this->postJson(route('v1.auth.login'), [
            'email' => 'jackson@gmail.com',
            'password' => 'jack6070!A',
            'device_name' => 'apple'
        ])->assertOk();
        $this->assertArrayHasKey('token', $response->json());
    }
}
