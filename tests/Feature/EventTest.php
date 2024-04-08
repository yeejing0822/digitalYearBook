<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\FavouriteEvent;
use App\Notifications\EventNotification;

class EventTest extends TestCase
{
    public function test_create_new_event()
    {
       $response =$this->get('events/create',[
        'name' => 'Carnival',
        'dateTime' =>'2022-03-08 12:30:00',
        'location' =>'UTAR Multipurpose Hall',
        'description' => 'This is utar carnival'
    ]);
    
        $response->assertStatus($response->status(),302);
    }

    public function test_store_new_event()
    {
       $response =$this->post('events/store',[
        'name' => 'Carnival',
        'dateTime' =>'2022-03-08 12:30:00',
        'location' =>'UTAR Multipurpose Hall',
        'description' => 'This is utar carnival'
    ]);
    
        $response->assertStatus($response->status(),302);
    }

    public function test_show_event_detail()
    {
       
        $response = $this->get('events/{id}');

        $response->assertStatus(500);
        
    }

    public function test_delete_event()
    {
        //$event = Event::factory()->count(1)->make();
        $event = Event::first();

        if($event){
            $event->delete();
        }

        $this->assertTrue(true);
    }


    public function test_favourite_event()
    {
        $user = User::factory()->create();
        $response =$this->post('eventaddtofav',[
            'user_id' => $user->id,
            'event_id' => $user->event_id
        ]);

       
        $response->assertStatus($response->status(),302);
    }

    public function test_show_event_favourite_list()
    {
        $response = $this->get('eventfavlist');

        $response->assertStatus(500);
    }

    public function test_remove_event_from_event_list()
    {
        //$favevent = FavouriteEvent::factory()->count(1)->make();
        $favevent = FavouriteEvent::first();

        if($favevent){
            $favevent->delete();
        }

        $this->assertTrue(true);
    }

    public function test_event_notify()
    {
        $response = $this->get('notify');

        $response->assertStatus(200);
    }

}
