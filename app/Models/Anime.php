<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function seasons()
    {
        return $this->hasMany('App\Models\Season');
    }

    public function mangas()
    {
        return $this->hasMany('App\Models\Manga');
    }

    public function movies()
    {
        return $this->hasMany('App\Models\Movie');
    }

    public function ovas()
    {
        return $this->hasMany('App\Models\Ova');
    }

    public function lightnovels()
    {
        return $this->hasMany('App\Models\LightNovel');
    }

    public function genders()
    {
        $this->hasMany('App\Models\AnimeGender');
    }
    
}
