<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index', [
            'app_name' => config('app.name'),
            'enable_notifications' => Setting::get('enable_notifications', false),
            'maintenance_mode' => file_exists(storage_path('framework/down')),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
        ]);

        Setting::set('enable_notifications', $request->has('enable_notifications'));

        $isCurrentlyDown = file_exists(storage_path('framework/down'));

        if ($request->has('maintenance_mode') && !$isCurrentlyDown) {
            // Generate a secret URL for bypass
            $secret = Str::random(32);
            Setting::set('maintenance_secret', $secret);

            // Put the app into maintenance mode with a secret
            Artisan::call('down', ['--secret' => $secret]);
        } elseif (!$request->has('maintenance_mode') && $isCurrentlyDown) {
            Artisan::call('up');
            Setting::forget('maintenance_secret');
        }

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Settings updated successfully!',
        ]);
    }
}
