<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;


class Post extends Model
{

    protected $fillable = ['title', 'content', 'slug', 'category_id'];

    public function author() {
        return $this->belongsTo('App\User');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
