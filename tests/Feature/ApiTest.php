<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_userCanSubscribeToSection() {

                $response = $this->post(route('subscribe'), [
                    'email' => 'testmail@rambler.ru',
                    'section' => '1'
                ]);

                $response
                    ->assertStatus(201)
                    ->assertJson([
                        'created' => true,
                    ]);;
    }

}
