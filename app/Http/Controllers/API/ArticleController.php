<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller {
  public function index(Request $req) {
    $q = Article::query();
    if($req->filled('q')) {
      $q->where(function($r) use ($req) {
        $r->where('title','like','%'.$req->q.'%')->orWhere('content','like','%'.$req->q.'%');
      });
    }
    if($req->filled('source')) $q->where('source_name',$req->source);
    if($req->filled('category')) $q->where('category',$req->category);
    if($req->filled('author')) $q->where('author',$req->author);
    if($req->filled('from')) $q->where('published_at','>=',$req->from);
    if($req->filled('to')) $q->where('published_at','<=',$req->to);
    $perPage = $req->get('per_page', 12);
    $res = $q->orderBy('published_at','desc')->paginate($perPage);
    return response()->json($res);
  }
  public function show($id){ return Article::findOrFail($id); }
  public function sources(){ $sources = Article::query()->select('source_name')->distinct()->pluck('source_name'); return response()->json($sources); }
  public function categories(){ $cats = Article::query()->select('category')->distinct()->pluck('category'); return response()->json($cats); }
  public function feed(Request $req){ $user = $req->user(); $prefs = $user->preferences ?: []; $q = Article::query();
    if(!empty($prefs['sources'])) $q->whereIn('source_name',$prefs['sources']);
    if(!empty($prefs['categories'])) $q->whereIn('category',$prefs['categories']);
    if(!empty($prefs['authors'])) $q->whereIn('author',$prefs['authors']);
    $res = $q->orderBy('published_at','desc')->paginate(12);
    return response()->json($res);
  }
}
