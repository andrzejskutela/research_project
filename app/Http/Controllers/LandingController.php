<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\DataGroupRun;
use App\Models\DataLead;
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

    public function startFromGroup(Request $request) {
        $code = $request->route()->parameter('code');
        $group = DataGroupRun::where('code', $code)->where('status', DataGroupRun::STATUS_NEW)->firstOrFail();
        session(['unique_id' => Str::uuid(), 'visited' => []]);
        $lead = $group->participants()->create([
                'uuid' => session('unique_id'),
                'leg' => $group->leg,
                'is_new_browser' => true,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'completed' => false,
        ]);

        return Inertia::render('NewGroupIntro', [
            'data' => [
                'check_link' => route('new_group_start_check', ['uuid' => session('unique_id')]),
                'continue_link' => route('introduction', ['uuid' => session('unique_id')]),
            ]
        ]);
    }

    public function checkProgress(Request $request) {
        $uuid = $request->route()->parameter('uuid');
        $lead = DataLead::where('uuid', $uuid)->firstOrFail();
        $group = $lead->group()->firstOrFail();

        return response()->json([
            'uuid' => session('unique_id'),
            'group' => $group->code,
            'allow_next_step' => $group->status === DataGroupRun::STATUS_RUNNING,
        ]);
    }
}
