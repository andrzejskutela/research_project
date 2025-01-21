<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function welcome(Request $request) {
        session(['unique_id' => Str::uuid()]);

        return Inertia::render('Landing', [
            'data' => [
                'continue_link' => route('new_participant', ['uuid' => session('unique_id')])
            ]
        ]);
    }
}
