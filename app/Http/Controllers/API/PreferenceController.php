<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreferenceController extends Controller {
  public function update(Request $req) {
    $user = $req->user();
    $data = $req->validate(['sources'=>'nullable|array','categories'=>'nullable|array','authors'=>'nullable|array']);
    $user->preferences = $data;
    $user->save();
    return response()->json(['message'=>'Preferences saved','preferences'=>$user->preferences]);
  }
  public function show(Request $req){ return response()->json($req->user()->preferences ?: []); }
}
