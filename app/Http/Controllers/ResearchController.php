<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Research\MemoryTest;

class ResearchController extends Controller
{
    public function newParticipant(Request $request) {
        return Inertia::render('NewParticipant', [
            'data' => [
                'continue_link' => route('introduction', ['uuid' => session('unique_id')])
            ]
        ]);
    }

    public function introduction(Request $request) {
        return Inertia::render('Introduction', [
            'data' => [
                'continue_link' => route('preparation', ['uuid' => session('unique_id')])
            ]
        ]);
    }

    public function preparation(Request $request) {
        return Inertia::render('Preparation', [
            'data' => [
                'continue_link' => route('memory_task', ['uuid' => session('unique_id')])
            ]
        ]);
    }

    public function memoryTask(Request $request) {
        $test = app()->make(MemoryTest::class);

        return Inertia::render('MemoryTask', [
            'data' => [
                'continue_link' => route('form', ['uuid' => session('unique_id')]),
                'order' => $test->getOrder(),
                'images' => $test->getTestImages(),
                'displayRules' => $test->getImageDisplayRandomnessSettings(),
            ]
        ]);
    }

    public function form(Request $request) {
        return Inertia::render('Form', [
            'data' => [
                'continue_link' => route('final', ['uuid' => session('unique_id')])
            ]
        ]);
    }

    public function final(Request $request) {
        return Inertia::render('Final', [
            'data' => [
                
            ]
        ]);
    }
}
