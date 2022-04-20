<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    /**
     * Test retrieving the index page
     *
     * @return void
     */
    public function test_get_index()
    {
        $response = $this
            ->followingRedirects()
            ->get('/');

        $response->assertViewIs('welcome');
    }

    public function test_get_create()
    {
        $response = $this
            ->followingRedirects()
            ->get('/create');

        $response->assertViewIs('create-contact');
    }



    public function test_making_store_request()
    {
        $response = $this->post('/users/store',
            ['first_name' => 'Curtis', 'last_name' => 'Berry', 'phone' => '019123456789', 'email' => 'email@email.com']);

        $message = "Contact added successfully";
        $response->assertRedirectToSignedRoute('users.index', [$message]);


    }
}
