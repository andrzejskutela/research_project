<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingController extends Controller
{
    public function welcome(Request $request) {
        return Inertia::render('Landing', [
            'user' => [
                'name' => 'abc'
            ]
        ]);
    }
}
