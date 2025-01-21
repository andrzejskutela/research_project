<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Research\MemoryTest;

class ResearchController extends Controller
{
    public function start(Request $request) {
        return Inertia::render('Ethics', [
            'data' => [
                'continue_link' => route('info_form')
            ]
        ]);
    }

    public function infoForm(Request $request) {
        return Inertia::render('InfoForm', [
            'data' => [
                'continue_link' => route('experiment')
            ]
        ]);
    }

    public function experiment(Request $request) {
        return Inertia::render('Experiment', [
            'data' => [
                'continue_link' => route('explanation')
            ]
        ]);
    }

    public function explanation(Request $request) {
        return Inertia::render('Experiment', [
            'data' => [
                'continue_link' => route('memory_test')
            ]
        ]);
    }

    public function memoryTest(Request $request) {
        $test = app()->make(MemoryTest::class);

        return Inertia::render('MemoryTest', [
            'data' => [
                'continue_link' => route('final'),
                'order' => $test->getOrder(),
                'images' => $test->getTestImages(),
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
