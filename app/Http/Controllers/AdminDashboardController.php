<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use App\Models\DataLead;
use App\Models\DataGroupRun;

class AdminDashboardController extends Controller
{
    public function dashboard(Request $request) {
        return Inertia::render('AdminDashboard', [
            'data' => [
                'new_group_link' => route('register_new_group'),
            ]
        ]);
    }

    public function newGroup(Request $request) {
        $legs = [
            'c' => DataLead::LEG_CONTROL,
            'i' => DataLead::LEG_INTERVENTION,
        ];

        $request->validate([
            'label' => 'required|string|between:3,100',
            'group' => [
                'required',
                Rule::in(array_keys($legs)),
            ],
        ]);

        $group = DataGroupRun::create([
            'code' => DataGroupRun::generateRandomGroupCode(),
            'leg' => $legs[ $request->input('group') ],
            'label' => $request->input('label'),
            'status' => DataGroupRun::STATUS_NEW,
        ]);

        $group->generateQRImage(route('start_new_from_group', ['code' => $group->code]));

        return response()->json([
            'data' => [
                'continue_link' => route('start_new_group', ['code' => $group->code])
            ]
        ]);
    }

    public function startGroup(Request $request) {
        $code = $request->route()->parameter('code');
        $group = DataGroupRun::where('code', $code)->firstOrFail();

        return Inertia::render('GroupIntroduction', [
            'data' => [
                'qr_img' => asset('/qr/' . $group->id . '.png'),
                'full_link' => route('start_new_from_group', ['code' => $group->code]),
                'leg' => $group->leg,
                'continue_link' => route('group_instructions', ['code' => $group->code])
            ]
        ]);
    }

    public function groupInstructions(Request $request) {
        $code = $request->route()->parameter('code');
        $group = DataGroupRun::where('code', $code)->firstOrFail();

        return Inertia::render('GroupInstructions', [
            'data' => [
                'continue_link' => route('enable_group_task', ['code' => $group->code])
            ]
        ]);
    }

    public function enableTask(Request $request) {
        $code = $request->route()->parameter('code');
        $group = DataGroupRun::where('code', $code)->firstOrFail();
        $group->status = DataGroupRun::STATUS_RUNNING;
        $group->save();

        return Inertia::render('EnableGroupTask', [
            'data' => [
            ]
        ]);
    }
}
