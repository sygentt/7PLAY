<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function show(Request $request): View
    {
        $settings = UserSetting::firstOrCreate(
            ['user_id' => $request->user()->id],
            []
        );

        return view('profile.settings', compact('settings'));
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'email_notif' => 'required|boolean',
            'push_notif' => 'required|boolean',
        ]);

        $settings = UserSetting::firstOrCreate(
            ['user_id' => $request->user()->id],
            []
        );

        $settings->update($validated);

        return response()->json(['success' => true]);
    }
}
