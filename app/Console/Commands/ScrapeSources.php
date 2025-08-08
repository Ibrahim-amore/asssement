<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Services\NewsApiService;
use App\Services\GuardianService;
use App\Services\NyTimesService;
use App\Models\Article;
use Carbon\Carbon;

class ScrapeSources extends Command {
  protected $signature = 'scrape:all';
  protected $description = 'Scrape configured news sources and save articles';

  public function handle(NewsApiService $newsApi, GuardianService $guardian, NyTimesService $ny) {
    $this->info('Starting scrape...');
    $newsData = $newsApi->fetch(50);
    foreach($newsData as $item) {
      if(!isset($item['url'])) continue;
      Article::updateOrCreate(['url'=>$item['url']], [
        'title'=>$item['title'] ?? null,
        'content'=>$item['content'] ?? $item['description'] ?? null,
        'author'=>$item['author'] ?? null,
        'source_name'=>$item['source']['name'] ?? null,
        'image_url'=>$item['urlToImage'] ?? null,
        'published_at'=>isset($item['publishedAt']) ? Carbon::parse($item['publishedAt']) : null,
        'scraped_at'=>now()
      ]);
    }
    $gData = $guardian->fetch(50);
    foreach($gData as $item) {
      $url = $item['webUrl'] ?? null; if(!$url) continue;
      Article::updateOrCreate(['url'=>$url], [
        'title'=>$item['webTitle'] ?? null,
        'content'=>$item['fields']['bodyText'] ?? null,
        'author'=>$item['fields']['byline'] ?? null,
        'source_name'=>'The Guardian',
        'image_url'=>$item['fields']['thumbnail'] ?? null,
        'published_at'=>isset($item['webPublicationDate']) ? Carbon::parse($item['webPublicationDate']) : null,
        'scraped_at'=>now()
      ]);
    }
    $nyData = $ny->fetch(10);
    foreach($nyData as $doc) {
      $url = $doc['web_url'] ?? null; if(!$url) continue;
      Article::updateOrCreate(['url'=>$url], [
        'title'=>$doc['headline']['main'] ?? null,
        'content'=>$doc['abstract'] ?? null,
        'author'=>$doc['byline']['original'] ?? null,
        'source_name'=>'NYTimes',
        'image_url'=>null,
        'published_at'=>isset($doc['pub_date']) ? Carbon::parse($doc['pub_date']) : null,
        'scraped_at'=>now()
      ]);
    }
    $this->info('Scrape completed.');
  }
}
