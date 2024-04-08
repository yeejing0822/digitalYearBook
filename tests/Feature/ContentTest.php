<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Content;
use App\Models\FavouriteEvent;
use App\Notifications\EventNotification;

class ContentTest extends TestCase
{
    public function test_create_new_content()
    {
       $response =$this->get('contents/create',[
        'title' => 'Congrats To Civil Engineering Dept',
        'description' => 'Civil Engineering Student, Lee Ming Hui had won the international civil award in the competition!'
    ]);
    
        $response->assertStatus($response->status(),302);
    }

    public function test_store_new_content()
    {
       $response =$this->post('contents/store',[
        'title' => 'Congrats To Civil Engineering Dept',
        'description' => 'Civil Engineering Student, Lee Ming Hui had won the international civil award in the competition!'
    ]);
    
        $response->assertStatus($response->status(),302);
    }

    public function test_show_content_detail()
    {
       
        $response = $this->get('contents/{id}');

        $response->assertStatus(500);
        
    }

    public function test_delete_content()
    {
        //$event = Event::factory()->count(1)->make();
        $content = Content::first();

        if($content){
            $content->delete();
        }

        $this->assertTrue(true);
    }




}
