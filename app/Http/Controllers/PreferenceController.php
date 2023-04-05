<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Preference;
use App\Http\Requests\StorePreferenceRequest;
use App\Http\Resources\PreferencesResource;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return PreferencesResource::collection(
         Preference::where('user_id',Auth::user()->id)->get()
     );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePreferenceRequest $request)
    {
        $request->validated($request->all());
        $preference=Preference::create([
            'user_id'=>Auth::user()->id,
            'name'=>$request->name,
        ]);
        return new PreferencesResource($preference);
    }

    /**
     * Display the specified resource.
     */
    public function show(Preference $preference)
    {
        return new PreferencesResource($preference);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
