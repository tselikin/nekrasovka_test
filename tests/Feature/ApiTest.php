<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Subscriber;
use App\Models\Section;
use Str;

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


    public function test_userCanUnsubscribeFromSection() {
        $subscriber = Subscriber::create(['email' => Str::random(10).'@gmail.com']);
        $section = Section::create(['title' => Str::random(10)]);
        $subscriber->sections()->attach($section->id);


        $response = $this->delete(route('subscribe'), [
            'email' => $subscriber->email,
            'section' => $section->id
        ]);
        

        $response
            ->assertStatus(200)
            ->assertJson([
                'unsubscribed' => true,
            ]);
    }




}
