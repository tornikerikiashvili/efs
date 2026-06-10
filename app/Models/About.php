<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class About extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTrixRichText;

    protected $fillable = [
        "page_id",
        "text_code",
        "text_en",
        "text_ka",
        "about-trixFields"
    ];

}
