<?php

namespace App\Concerns;

trait HasLocalizedImageAlt
{
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

        return trim((string) ($this->{'name_'.$locale} ?? ''));
    }
}
