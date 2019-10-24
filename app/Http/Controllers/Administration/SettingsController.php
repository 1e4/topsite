<?php

namespace App\Http\Controllers\Administration;

use App\Http\Requests\UpdateSEOSettingsRequest;
use App\Http\Requests\UpdateSettings;
use App\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function showSettings()
    {
        $settings = Settings::all();

        return view('administration.settings.edit', compact('settings'));
    }

    public function updateSettings(UpdateSettings $request): RedirectResponse
    {
        foreach (collect(config('settings'))->where('key', 'NOT LIKE', 'seo_%') as $key => $options) {
            $setting = Settings::where('key', $key)->first();
            $setting->value = $request->input($key);
            $setting->save();
        }

        flash("Settings have been updated")->success();

        return redirect()->back();
    }

    public function updateSEO(UpdateSEOSettingsRequest $request): RedirectResponse
    {

        $seo = Settings::where('key', 'LIKE', 'seo_%')->get();

        foreach ($seo as $setting) {
            $setting->value = $request->input($setting->key);
            $setting->save();
        }

        flash('SEO has been updated')->success();

        return redirect()->back();
    }
}
