<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function welcome(Request $request) {
        
        return Inertia::render('Landing', [
            'data' => [
                'continue_link' => route('redirect_uuid'),
                'refresh_error' => session('refresh_error')
            ]
        ]);
    }

    public function redirectWithNewUUID(Request $request) {
        session(['unique_id' => Str::uuid(), 'visited' => []]);
        return to_route('new_participant', ['uuid' => session('unique_id')]);
    }

    public function final(Request $request) {
        return Inertia::render('Final', [
            'data' => []
        ]);
    }
}
