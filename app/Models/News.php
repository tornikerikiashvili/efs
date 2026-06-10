<?php

namespace App\Models;

use App\Concerns\HasLocalizedSlugs;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTrixRichText, HasLocalizedSlugs;

    protected $fillable = [
        "name_ka",
        "name_en",
        "slug_ka",
        "slug_en",
        "meta_title_ka",
        "meta_title_en",
        "meta_description_ka",
        "meta_description_en",
        "image",
        "content_ka",
        "short_content_en",
        "short_content_ka",
        "content_en",
        "status",
        "news-trixFields"
    ];

    public function trixRender($field)
    {
        $get = $this->trixRichText->where('field', $field)->first();
        if(!$get) return false;
        return $get->content;
    }
}
