<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Research\MemoryTest;
use Illuminate\Validation\Rule;
use App\Models\DataLead;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

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
                'continue_link' => route('preparation', ['uuid' => session('unique_id')]),
                'data_link' => route('register_data', ['uuid' => session('unique_id')]),
                'uuid' => session('unique_id'),
                'order' => [ MemoryTest::SET_FLOWERS ],
                'images' => [
                    MemoryTest::SET_FLOWERS => [
                        asset('/images/flowers/01.jpg'),
                        asset('/images/flowers/02.jpg'),
                        asset('/images/flowers/03.jpg')
                    ]
                ],
                'displayRules' => $ret = [
                    0 => '1',
                    1 => '1,2',
                    2 => '1,3,2',
                ],
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

    public function registerData(Request $request) {
        $request->validate([
            'uuid' => ['required', 'uuid', Rule::in( [ session('unique_id') ] ),],
            'set' => [
                'required',
                Rule::in([ MemoryTest::SET_NATURE, MemoryTest::SET_MEN, MemoryTest::SET_WOMEN, MemoryTest::SET_FLOWERS ]),
            ],
            'score' => 'required|integer|between:0,40',
            'timings' => 'required|array',
            'timings.*' => 'integer'
        ]);

        $lead = DataLead::firstOrCreate(
            [ 'uuid' => $request->input('uuid') ],
            [
                'leg' => DataLead::LEG_CONTROL, // get from session
                'data_entry_code' => DataLead::ENTRY_SINGLE,
                'email' => null,
                'is_new_browser' => true,
                'ip' => $request->ip(),
                'country' => null,
                'ip_info' => null,
                'age' => null,
                'gender' => null,
                'meditation_experience' => null
        ]);

        $validator = Validator::make($request->all(), [
             'set' => [
                'required',
                Rule::unique('data_measurements', 'dataset_uid')->where(function (Builder $query) use($lead) {
                    $query->where('data_lead_id', $lead->id);
                })
            ],
        ])->validate();

        $totalTime = 0;
        $mappedTimings = Arr::map($request->input('timings'), function (int $value, string $key) use (&$totalTime) {
            $totalTime += $value;
            return round((int)$value / 1000, 2);
        });

        $lead->measurements()->create([
            'dataset_uid' => $request->input('set'),
            'score' => $request->input('score'),
            'time_seconds' => round($totalTime / 1000, 2),
            'time_breakdown' => $mappedTimings,
        ]);

        return response()->json(['status' => 'success']);
    }
}
