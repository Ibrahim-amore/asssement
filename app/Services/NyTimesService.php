<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class NyTimesService {
  public function fetch($pageSize=10) {
    $key = env('NYTIMES_KEY');
    if(!$key) return [];
    $res = Http::get('https://api.nytimes.com/svc/search/v2/articlesearch.json', [
      'api-key'=>$key,
      'sort'=>'newest',
      'page'=>0
    ]);
    if(!$res->ok()) return [];
    return $res->json()['response']['docs'] ?? [];
  }
}
