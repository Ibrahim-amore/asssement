<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up() {
    Schema::create('articles', function (Blueprint $table) {
      $table->id();
      $table->string('title')->nullable();
      $table->text('content')->nullable();
      $table->string('url')->unique();
      $table->string('author')->nullable();
      $table->string('source_name')->nullable();
      $table->string('category')->nullable();
      $table->string('image_url')->nullable();
      $table->timestamp('published_at')->nullable();
      $table->timestamp('scraped_at')->nullable();
      $table->timestamps();
    });
  }
  public function down() { Schema::dropIfExists('articles'); }
};
