<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PreferenceController;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::get('articles',[ArticleController::class,'index']);
Route::get('articles/{id}',[ArticleController::class,'show']);
Route::get('sources',[ArticleController::class,'sources']);
Route::get('categories',[ArticleController::class,'categories']);

Route::middleware('auth:sanctum')->group(function(){
  Route::post('logout',[AuthController::class,'logout']);
  Route::get('me',[AuthController::class,'me']);
  Route::get('feed',[ArticleController::class,'feed']);
  Route::post('preferences',[PreferenceController::class,'update']);
  Route::get('preferences',[PreferenceController::class,'show']);
});
