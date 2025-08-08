<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class GuardianService {
  public function fetch($pageSize=50) {
    $key = env('GUARDIAN_KEY');
    if(!$key) return [];
    $res = Http::get('https://content.guardianapis.com/search', [
      'api-key'=>$key,
      'page-size'=>$pageSize,
      'show-fields'=>'all'
    ]);
    if(!$res->ok()) return [];
    return $res->json()['response']['results'] ?? [];
  }
}
