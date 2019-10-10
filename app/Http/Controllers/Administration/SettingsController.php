<?php

namespace App\Http\Controllers\Administration;

use App\Http\Requests\UpdateSettings;
use App\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function showSettings() {
        $settings = Settings::all();

        return view('administration.settings.edit', compact('settings'));
    }

    public function updateSettings(UpdateSettings $request) {
        foreach(config('settings') as $key => $options) {
            $setting = Settings::where('key', $key)->first();
            $setting->value = $request->input($key);
            $setting->save();
        }

        flash("Settings have been updated")->success();

        return redirect()->back();
    }
}
