<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\AdoptedCommunity;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the settings.
     */
    public function index()
    {
        return view('settings.index', [
            'schools' => School::all(),
            'communities' => AdoptedCommunity::all(),
        ]);
    }

    /**
     * Store or update a school.
     */
    public function storeSchool(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:schools,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:schools,code,' . $request->id,
            'description' => 'nullable|string',
        ]);

        School::updateOrCreate(
            ['id' => $request->id],
            $validated
        );

        return redirect()->route('settings.index')->with('success', 'School saved successfully!');
    }

    /**
     * Store or update a community.
     */
    public function storeCommunity(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:adopted_communities,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:adopted_communities,code,' . $request->id,
            'address' => 'required|string|max:255',
        ]);

        AdoptedCommunity::updateOrCreate(
            ['id' => $request->id],
            $validated
        );

        return redirect()->route('settings.index')->with('success', 'Community saved successfully!');
    }
}
