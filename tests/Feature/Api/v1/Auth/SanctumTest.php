<?php

namespace Tests\Feature\Api\v1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SanctumTest extends TestCase
{

    public function test_new_user_can_register()
    {
        $this->postJson(route('v1.auth.register'),[
            'first_name' => 'sam',
            'last_name' => 'samson',
            'email' => 'sam@gmail.com',
            'password' => 'Jack211!!!',
            'password_confirmation' => 'Jack211!!!'
        ])->assertCreated();
        $this->assertDatabaseHas('users', ['first_name' => 'jack']);
    }

    public function test_user_can_login()
    {
        $response = $this->postJson(route('v1.auth.login'), [
            'email' => 'sam@gmail.com',
            'password' => '$2y$10$FgGS3pQDO0vM5goqJs1UQ.2aAvTZwej1XxJplagmsKVGQyAekJa/S',
            'device_name' => 'apple'
        ])->assertOk();
        $this->assertArrayHasKey('token', $response->json());
    }

    public  function test_user_invalid_can_login()
    {
        $this->postJson(route('v1.auth.login'),[
            'email' => 'adam@gmail.com',
            'password' => '$2y$10$FgGS3pQDO0vM5goqJs1UQ.2aAvTZwej1XxJplagmsKVGQyAekJa/S',
            'device_name' => 'samsung'
        ])->assertUnauthorized();

    }
}
