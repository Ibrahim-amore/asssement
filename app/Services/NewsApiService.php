<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class NewsApiService {
  public function fetch($pageSize=50) {
    $key = env('NEWSAPI_KEY');
    if(!$key) return [];
    $res = Http::get('https://newsapi.org/v2/top-headlines', [
      'apiKey'=>$key,
      'pageSize'=>$pageSize,
      'language'=>'en'
    ]);
    if(!$res->ok()) return [];
    return $res->json()['articles'] ?? [];
  }
}
