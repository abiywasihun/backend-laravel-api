<?php

namespace App\Http\Controllers;

use Auth;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Preference;
use App\Http\Requests\StorePreferenceRequest;
use App\Http\Resources\PreferencesResource;

class PreferenceController extends Controller
{
    use HttpResponses;
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
    public function store(Request $request)
    {
        $data = $request->all();

        foreach ($data as $item) {
            Preference::create([
                'user_id' => Auth::user()->id,
                'name' => $item['name'],
                'type' => $item['type'],
            ]);
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Preference $preference)
    {
        return $this->isNotAuthorized($preference)? $this->isNotAuthorized($preference): new PreferencesResource($preference);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Preference $preference )
    {
        if(Auth::user()->id!==$preference->user_id){
            return $this->error('','You are not authorized to make this request',403);
        }

        $preference->update($request->all());

        return new PreferencesResource($preference);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Preference $preference)
    {
        
        return $this->isNotAuthorized($preference)? $this->isNotAuthorized($preference): $preference->delete();
        return response(null,204);
    }
    private function isNotAuthorized($preference)
    {
        if(Auth::user()->id!==$preference->user_id){
            return $this->error('','You are not authorized to make this request',403);
        }
    }
}
