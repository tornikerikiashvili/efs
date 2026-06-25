<?php

namespace App\Models;

use App\Concerns\HasLocalizedImageAlt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TeamMember extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasLocalizedImageAlt;

    protected $fillable = [
        'name_ka',
        'name_en',
        'position_ka',
        'position_en',
        'image_alt_ka',
        'image_alt_en',
        'sort_order',
        'status',
    ];
}
