<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_homepage_loads()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
       // $response->assertSeeText('Hi from Index');
    }
}
