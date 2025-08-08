<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Article extends Model {
  protected $fillable = [
    'title','content','url','author','source_name','category','image_url','published_at','scraped_at'
  ];

  protected $dates = ['published_at','scraped_at'];
}
