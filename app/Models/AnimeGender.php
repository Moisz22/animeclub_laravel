<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimeGender extends Model
{
    use HasFactory;

    public function anime()
    {
        $this->belongsTo('App\Models\Anime');
    }

    public function gender()
    {
        $this->belongsTo('App\Models\Gender');
    }
}
