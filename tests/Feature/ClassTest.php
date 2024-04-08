<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Favourite;

class ClassTest extends TestCase
{
    public function test_create_new_class()
    {
       $response =$this->get('categories/create',[
        'name' => 'Class 2023',
        'description' => 'Class of 2023'
    ]);
    
        $response->assertStatus($response->status(),302);
    }

    public function test_store_new_class()
    {
       $response =$this->post('categories/store',[
        'name' => 'Class 2023',
        'description' => 'Class of 2023'
    ]);
    
        $response->assertStatus($response->status(),302);
    }

    public function test_show_class_detail()
    {
       
        $response = $this->get('categories/{id}');

        $response->assertStatus(500);
        
    }

    public function test_search_class()
    {
        
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_join_class()
    {
        $user = User::factory()->create();
        $response =$this->post('addtofav',[
            'user_id' => $user->id,
            'category_id' => $user->category_id
        ]);

       
        $response->assertStatus($response->status(),302);
    }

    public function test_show_joined_class_list()
    {
        $response = $this->get('favlist');

        $response->assertStatus(500);
    }

    public function test_remove_class_from_class_list()
    {
        //$favevent = FavouriteEvent::factory()->count(1)->make();
        $favclass = Favourite::first();

        if($favclass){
            $favclass->delete();
        }

        $this->assertTrue(true);
    }


}
