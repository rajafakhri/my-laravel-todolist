<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
        ->assertSeeText("Login");
    }

    public function testLoginSuccess()
    {
        $this->post('/login',[
            "user" => "raja",
            "password"=> "12345"
        ])->assertRedirect("/")
            ->assertSessionHas("user","raja");
    }
}
