<?php

namespace App\Http\Controllers;

use App\Acme\Traits\UserSettingsTrait;
use App\Http\Requests\UserSettingsRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserSettingsController extends Controller
{
    use UserSettingsTrait;

    /**
     * View form to edit specific resource
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('Settings/Edit', [
            'values' => $this->getValues(Auth::user()),
            'settings' => $this->getSettings(Auth::user()),
        ]);
    }

    /**
     * Update specific resource
     *
     * @param UserSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserSettingsRequest $request)
    {
        Auth::user()->update($request->validated());

        return redirect()->back()->with('success', 'Podešavanja su uspešno izmenjena');
    }
}
