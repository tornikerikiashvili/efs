<?php

namespace App\Models;

use App\Concerns\HasLocalizedSlugs;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projects extends Model implements HasMedia
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
        "og_title_ka",
        "og_title_en",
        "og_description_ka",
        "og_description_en",
        "image",
        "content_ka",
        "content_en",
        "status",
        "projects-trixFields"
    ];

    public function trixRender($field)
    {
        $get = $this->trixRichText->where('field', $field)->first();
        if(!$get) return false;
        return $get->content;
    }
}
