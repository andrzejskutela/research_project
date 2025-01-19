<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingController extends Controller
{
    public function welcome(Request $request) {
        return Inertia::render('Landing', [
            'data' => [
                'continue_link' => route('new_participant')
            ]
        ]);
    }
}
