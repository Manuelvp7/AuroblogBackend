<?php

namespace App;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Events\SavingPost;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
     protected $fillable = ['title','content','slug', 'created_at'];


    protected static function booted()
    {
        static::saving(function ($post) {

          $post->slug = Str::slug($post->title);
          $posts = Post::where('slug', 'like' , '%'.$post->slug.'%')->get();

          if($posts->count() > 0){
               $post->slug = $post->slug.'-'.$posts->count();
          }

        });
    }
}
