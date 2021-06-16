<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;


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
            'section' => 'required|exists:sections,id',
        ]);

        $subscriber = Subscriber::where('email', $request->email)->first();
        $subscriber->sections()->detach($request->section);


        return response()->json(['unsubscribed' => True], 200);
    }


    public function subscriberSubscriptions(Subscriber $subscriber)
    {
        // dd($subscriber);
    }
}
