<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body'];
    
    public function comments() {
      return $this->hasMany('App\Models\Comment');
    }
    
    public function pic_thum()
    {
      $fnamebase = \Config::get('fpath.thum').$this->id."/"."thum.";
   
      if(file_exists(public_path().$fnamebase."gif")){
        return $fnamebase."gif";
      }else if(file_exists(public_path().$fnamebase."png")){
        return $fnamebase."png";
      }else if(file_exists(public_path().$fnamebase."jpg")){
        return $fnamebase."jpg";
      }else if(file_exists(public_path().$fnamebase."jpeg")){
        return $fnamebase."jpeg";
      }else{
        return \Config::get('fpath.noimage');
      }
    }
}
