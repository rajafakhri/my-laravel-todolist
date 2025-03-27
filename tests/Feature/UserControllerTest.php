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

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "raja"
        ])->get("/login")
            ->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->post('/login',[
            "user" => "raja",
            "password"=> "12345"
        ])->assertRedirect("/")
            ->assertSessionHas("user","raja");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "raja",
        ])->post('/login',[
            "user" => "raja",
            "password"=> "12345"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post("/login",[])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post("/login",[
            "user" => "Wrong",
            "password" => "Wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "raja"
        ])->post("/logout")
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post("/logout")
            ->assertRedirect("/");
    }
}
