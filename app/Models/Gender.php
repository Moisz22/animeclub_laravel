<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function genders()
    {
        $this->hasMany('App\Models\AnimeGender');
    }

}
