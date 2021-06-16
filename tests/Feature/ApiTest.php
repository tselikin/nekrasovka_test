<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
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

    public function test_userCantSubscribeToSectionWithoutSectionID() {
        $response = $this->post(route('subscribe'), [
            'email' => 'testmail2@rambler.ru',
            // 'section' => '1'
        ]);

        $response->assertStatus(302);
    }

    public function test_userCantSubscribeToNotExistingSection() {
        $response = $this->post(route('subscribe'), [
            'email' => 'testmail3@rambler.ru',
            'section' => '100000'
        ]);

        $response->assertStatus(302);
    }

}
