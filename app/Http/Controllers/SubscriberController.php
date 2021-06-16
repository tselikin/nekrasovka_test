<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'section' => 'required|exists:sections,id',
        ]);

        $subscriber = Subscriber::firstOrCreate(['email' => $request->email]);

        if (!$subscriber->sections->contains($request->section))
            $subscriber->sections()->attach($request->section);


        return response()->json(['created' => True], 201);
    }


    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|exists:subscribers,email',
            'section' => 'exists:sections,id'
        ]);

        $subscriber = Subscriber::where('email', $request->email)->first();

        if ($request->section)  {
            $subscriber->sections()->detach($request->section);
            return response()->json(['unsubscribed' => True], 200);
        }

        $subscriber->sections()->detach();
        return response()->json(['unsubscribedFromAllSections' => True], 200);
    }


    public function getApiToken(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        $user = User::where([
            'email' => $request->email,
        ])->firstOrFail();

        if (Hash::check($request->password, $user->password))
            return response()->json([
                'successful api login' => True,
                'apitoken' =>  $user->updateApiToken()
            ], 200);
    }


    public function clearApiToken(Request $request)
    {
        $validated = $request->validate([
            'api_token' => 'required|max:255|exists:users,api_token',
        ]);

        $user = User::where([
            'api_token' => $request->api_token,
        ])->first();

        $user->clearApiToken();

        return response()->json([
            'api token cleared' => True,
        ], 200);
    }


    public function subscriberSections(Subscriber $subscriber, Request $request)
    {
        $validated = $request->validate([
            'api_token' => 'required|max:255|exists:users,api_token',
            'offset' => 'required|numeric',
            'limit' => 'required|numeric'
        ]);

        $sections = $subscriber->sections()
                               ->skip($request->offset)
                               ->take($request->limit)
                               ->get();

        $totalSections = $subscriber->sections->count();

        return response()->json([
            'total' => $totalSections,
            'sections' => $sections->toJson()
        ]);
    }


    public function sectionSubscribers(Section $section, Request $request)
    {
        $validated = $request->validate([
            'api_token' => 'required|max:255|exists:users,api_token',
            'offset' => 'required|numeric',
            'limit' => 'required|numeric'
        ]);

        $subscribers = $section->subscribers()
                               ->skip($request->offset)
                               ->take($request->limit)
                               ->get();

        $totalSubscribers = $section->subscribers->count();

        return response()->json([
            'total' => $totalSubscribers,
            'subscribers' => $subscribers->toJson()
        ]);
    }



}
