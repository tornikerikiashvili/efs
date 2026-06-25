<?php

namespace App\Models;

use App\Concerns\HasLocalizedImageAlt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PartnerLogo extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasLocalizedImageAlt;

    protected $fillable = [
        'name',
        'url',
        'image_alt_ka',
        'image_alt_en',
        'sort_order',
        'status',
    ];

    public function imageAltForLocale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $alt = trim((string) ($this->{'image_alt_'.$locale} ?? ''));

        if ($alt !== '') {
            return $alt;
        }

        $fallbackLocale = $locale === 'ka' ? 'en' : 'ka';
        $alt = trim((string) ($this->{'image_alt_'.$fallbackLocale} ?? ''));

        if ($alt !== '') {
            return $alt;
        }

        return trim((string) ($this->name ?? ''));
    }
}
