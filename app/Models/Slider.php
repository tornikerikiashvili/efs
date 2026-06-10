<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'slider';

    protected $fillable = [
        "name_ka",
        "name_en",
        "link",
        "type",
        "alt_name",
        "status",
        "sort"
    ];

}
