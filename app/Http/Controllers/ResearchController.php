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
        $leg = null;
        if (session('unique_id') == $request->route()->parameter('uuid')) {
            $lead = DataLead::where('uuid', session('unique_id'))->whereNotNull('data_group_run_id')->first();
            if ($lead) {
                $leg = $lead->leg;
            }
        }

        if ($leg === null) {
            $controlRuns = DataLead::where('completed', true)->where('leg', DataLead::LEG_CONTROL)->where('is_new_browser', true)->count();
            $interventionRuns = DataLead::where('completed', true)->where('leg', DataLead::LEG_INTERVENTION)->where('is_new_browser', true)->count();
            $leg = $controlRuns > $interventionRuns ? DataLead::LEG_INTERVENTION : DataLead::LEG_CONTROL;
            // $leg = DataLead::LEG_INTERVENTION;
        }
        
        session(['leg' => $leg]);

        return Inertia::render('Introduction', [
            'data' => [
                'continue_link' => $leg === DataLead::LEG_INTERVENTION ?
                    route('preparation', ['uuid' => session('unique_id')])
                    : route('memory_task', ['uuid' => session('unique_id')]),
                'data_link' => route('register_data', ['uuid' => session('unique_id')]),
                'uuid' => session('unique_id'),
                'order' => [ MemoryTest::SET_FLOWERS ],
                'display_control_info' => $leg === DataLead::LEG_CONTROL ? true : false,
                'images' => [
                    MemoryTest::SET_FLOWERS => [
                        asset('/images/flowers/01.jpg'),
                        asset('/images/flowers/02.jpg'),
                        asset('/images/flowers/03.jpg'),
                        asset('/images/flowers/04.jpg'),
                        asset('/images/flowers/05.jpg')
                    ]
                ],
                'display_rules' => $ret = [
                    0 => '1',
                    1 => '1,2',
                    2 => '1,3,2',
                    3 => '2,3,1,4',
                    4 => '3,1,5,2,4',
                ],
            ]
        ]);
    }

    public function preparation(Request $request) {
        return Inertia::render('Preparation', [
            'data' => [
                'continue_link' => route('memory_task', ['uuid' => session('unique_id')]),
                'audio_uri' => asset('/audio/test.mp3'),
            ]
        ]);
    }

    public function memoryTask(Request $request) {
        $test = app()->make(MemoryTest::class);

        return Inertia::render('MemoryTask', [
            'data' => [
                'continue_link' => route('form', ['uuid' => session('unique_id')]),
                'data_link' => route('register_data', ['uuid' => session('unique_id')]),
                'uuid' => session('unique_id'),
                'display_control_info' => false,
                'order' => $test->getOrder(),
                'images' => $test->getTestImages(),
                'display_rules' => $test->getImageDisplayRandomnessSettings(),
            ]
        ]);
    }

    public function form(Request $request) {
        return Inertia::render('Form', [
            'data' => [
                'uuid' => session('unique_id'),
                'form_link' => route('register_form', ['uuid' => session('unique_id')])
            ]
        ]);
    }

    public function final(Request $request) {
        return Inertia::render('Final', [
            'data' => [
                'app_url' => route('landing_page'),
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

        $isNewBrowser = $request->input('reentry_flag', '') === '' ? true : false;

        $lead = DataLead::firstOrCreate(
            [ 'uuid' => $request->input('uuid') ],
            [
                'leg' => session('leg', DataLead::LEG_INTERVENTION),
                'data_group_run_id' => null,
                'is_new_browser' => $isNewBrowser,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'completed' => false,
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

    public function registerForm(Request $request) {
        $request->validate([
            'uuid' => ['required', 'uuid', Rule::in( [ session('unique_id') ] ),],
            'age' => 'required|integer|between:18,99',
            'email' => 'nullable|email:rfc,strict',
            'gender' => [
                'required',
                Rule::in([ DataLead::GENDER_FEMALE, DataLead::GENDER_MALE, DataLead::GENDER_NA ]),
            ],
            'meditation' => [
                'nullable',
                Rule::in([ DataLead::EXP_NONE, DataLead::EXP_SOME, DataLead::EXP_REGULAR ]),
            ],
            'exercise' => [
                'nullable',
                Rule::in([ DataLead::EXP_NONE, DataLead::EXP_SOME, DataLead::EXP_REGULAR ]),
            ],
            'coffee' => [
                'nullable',
                Rule::in([ DataLead::EXP_NONE, DataLead::EXP_SOME, DataLead::EXP_REGULAR ]),
            ],
            'english' => [
                'required',
                Rule::in([ 'y', 'n' ]),
            ],
        ]);

        $lead = DataLead::where('uuid', $request->input('uuid'))->firstOrFail();
        $fields = [
            'age' => 'age', 
            'gender' => 'gender',
            'meditation' => 'meditation_exp',
            'exercise' => 'exercise_exp',
            'coffee' => 'coffee_exp',
            'email' => 'email'
        ];

        foreach ($fields as $k => $v) {
            $value = $request->input($k, null);
            if ($value !== null) {
                $lead->$v = $value;
            }
        }

        $lead->english_native = $request->input('english', 'n') === 'y' ? true : false;

        if ($lead->measurements()->count() === count(MemoryTest::getAllPossibleSets())) {
            $lead->completed = true;
        }

        $lead->save();

        return response()->json([
            'continue_link' => route('final', ['uuid' => session('unique_id')])
        ]);
    }
}
