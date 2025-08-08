<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
  public function register(Request $req){
    $data = $req->validate([ 'name'=>'required','email'=>'required|email|unique:users','password'=>'required|min:6' ]);
    $user = User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password'])]);
    $token = $user->createToken('api-token')->plainTextToken;
    return response()->json(['user'=>$user,'token'=>$token]);
  }
  public function login(Request $req){
    $data = $req->validate(['email'=>'required|email','password'=>'required']);
    $user = User::where('email',$data['email'])->first();
    if(!$user || !Hash::check($data['password'],$user->password)) return response()->json(['message'=>'Invalid credentials'],401);
    $token = $user->createToken('api-token')->plainTextToken;
    return response()->json(['user'=>$user,'token'=>$token]);
  }
  public function logout(Request $req){ $req->user()->tokens()->delete(); return response()->json(['message'=>'Logged out']); }
  public function me(Request $req){ return response()->json($req->user()); }
}
