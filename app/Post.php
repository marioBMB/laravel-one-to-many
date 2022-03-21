<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\User;


class Post extends Model
{

    protected $fillable = ['title', 'content', 'slug', 'category_id', 'image'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
}

