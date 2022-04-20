<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ControllerTest extends TestCase
{

    public function test_get_data()
    {
        $response = storage_path('\app\public\contacts.json');

        self::assertFileExists($response);

    }

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

    /**
     * Get the create new record page
     */
    public function test_get_create()
    {
        $response = $this
            ->followingRedirects()
            ->get('/create');

        $response->assertViewIs('create-contact');
    }

    /**
     * Make a valid store request
     */
    public function test_store_request()
    {
        $response = $this->post('/users/store',
            array(['first_name' => 'Curtis', 'last_name' => 'Berry', 'phone' => '019123456789', 'email' => 'email@email.com']));

        $message = "Contact added successfully";
        $response->assertRedirect('/')->withHeaders([$message]);
    }

    /**
     * Make an invalid store request
     */
    public function test_false_store_request()
    {
        $response = $this->post('/users/store',
            array(['last_name' => 'Berry', 'phone' => '019123456789', 'email' => 'email@email.com']));

        //should redirect back if validation fails as first name is not supplied
        $response->assertRedirect('/');
    }

    /**
     * Make a valid show request
     */
    public function test_show_request()
    {
        $jsonString = file_get_contents(storage_path('\app\public\contacts.json'));

        $collection = collect(json_decode($jsonString, true));

        $data = $collection->all();

        //get last key of item that exists in array
        $data = array_key_first($data);

        // 0 is supplied to give first record in json file
        $response = $this->get('/users/' . $data);

        $response->assertViewIs('view-contact');
    }

    /**
     * Make an invalid show request
     */
    public function test_false_show_request()
    {
        $jsonString = file_get_contents(storage_path('\app\public\contacts.json'));

        $collection = collect(json_decode($jsonString, true));

        $data = $collection->all();

        //get last key of item that exists in array
        $data = array_key_last($data);

        //key supplied to a record in json file that does not currently exist
        $response = $this->get('/users/' . $data+=1);

        $errors = "The given id could not be found";
        $response->assertRedirect('/')->withHeaders([$errors]);
    }

    /**
     * Get the update record page
     */
    public function test_update_record_method()
    {
        $jsonString = file_get_contents(storage_path('\app\public\contacts.json'));

        $collection = collect(json_decode($jsonString, true));

        $data = $collection->all();

        //get last key of item that exists in array
        $data = array_key_first($data);

        $response = $this
            ->followingRedirects()
            ->get('/users/update/' . $data);

        $response->assertViewIs('update-contact');
    }

    /**
     * Make a valid update request
     */
    public function test_update_request()
    {
        $jsonString = file_get_contents(storage_path('\app\public\contacts.json'));

        $collection = collect(json_decode($jsonString, true));

        //get all records and then get the key of the first record
        $data = $collection->all();
        $data  = array_key_first($data);

        //update the first record in the file
        $response = $this->post('/users/update/' . $data,
            array(['first_name' => 'David', 'last_name' => 'Blatt', 'phone' => '01913478234', 'email' => 'david.blatt@corrie.co.uk']));

        $message = "Contact updated";
        $response->assertRedirect('/')->withHeaders([$message]);
    }

    /**
     * Make an invalid update request
     */
    public function test_false_update_request()
    {

    }
}
