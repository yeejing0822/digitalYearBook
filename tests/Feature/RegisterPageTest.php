<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterPageTest extends TestCase
{
    public function test_user_can_register()
    {
        $user = User::factory()->create();

        $response = $this->post('/register', [
            'name'=> $user->name,
            'email' => $user->email,
            'password' => 'password'
        ]);

       // $this->assertAuthenticated();

        $response->assertRedirect('/');
    }

    
}
