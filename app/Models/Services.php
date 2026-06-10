<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Services extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTrixRichText;

    protected $fillable = [
        "name_ka",
        "name_en",
        "meta_title_ka",
        "meta_title_en",
        "meta_description_ka",
        "meta_description_en",
        "image",
        "content_ka",
        "slug",
        "content_en",
        "status",
        "icon",
        "services-trixFields"
    ];

    public function trixRender($field)
    {
        $get = $this->trixRichText->where('field', $field)->first();
        if(!$get) return false;
        return $get->content;
    }
}
