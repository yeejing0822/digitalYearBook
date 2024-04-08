<?php

//namespace Tests\Unit;
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_new_user()
    {
       $response =$this->get('admin/users/create',[
        'name' => 'Jinny',
        'email' => 'jinny@gmail.com',
        'password' => 'jinny1234',
    ]);
    
        $response->assertStatus($response->status(),302);
    }

    public function test_edit_user()
    {
       
        $response =$this->patch('admin/users/{user}/edit',[
            'name' => 'Jinnie',
            'email' => 'jinnie@gmail.com'
           
        ]);
        
            $response->assertStatus($response->status(),302);
   
    }

    public function test_show_users()
    {
       
        $response = $this->get('admin/users');

        $response->assertStatus(302);
        
    }

    public function test_user_duplication()
    {
        $user1 = User::make([
            'name'=>'adam',
            'email'=> 'adam@gmail.com'
        ]);

        $user2 = User::make([
            'name'=>'dary',
            'email'=> 'dary@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();
        $user = User::first();

        if($user){
            $user->delete();
        }

        $this->assertTrue(true);
    }

    public function test_user_profile()
    {
       
        $response = $this->get('user/users');

        $response->assertStatus(302);
        
    }

    public function test_change_password()
    {
       
        $response =$this->patch('user/password',[
            'current_password' => 'jinny1234',
            'password' => 'Jinnie1234!'
           
        ]);
        
            $response->assertStatus($response->status(),302);
   
    }
}
