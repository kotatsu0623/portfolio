<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'comment'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    
    public function scopeRecommend($query, $self_id){
        return $query->where('id', '!=', $self_id)->inRandomOrder()->limit(3);
    }
    
}
