<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Subscriber;
use App\Models\Section;
use App\Models\User;
use Str;
use Illuminate\Support\Facades\Hash;

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


    public function test_userCanUnsubscribeFromALLSections() {
        $subscriber = Subscriber::create(['email' => Str::random(10).'@gmail.com']);
        $section = Section::create(['title' => Str::random(10)]);
        $section2 = Section::create(['title' => Str::random(10)]);
        $subscriber->sections()->attach($section->id);
        $subscriber->sections()->attach($section2->id);


        $response = $this->delete(route('subscribe'), [
            'email' => $subscriber->email,
        ]);


        $response
            ->assertStatus(200)
            ->assertJson([
                'unsubscribedFromAllSections' => true,
            ]);


        $this->assertDatabaseMissing('section_subscriber', [
            'section_id' => $section->id,
            'subscriber_id' => $subscriber->id,
        ]);
    }


    public function test_userCanGetApiTokenFromEmailAndPassword()
    {
        $password = Str::random(10);

        $user = User::factory()->make([
            'password' => Hash::make($password)
        ]);

        $user->save();

        $response = $this->post(route('getApiToken'), [
            'email' => $user->email,
            'password' => $password
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'successful api login' => true,
            ]);





    }




}
