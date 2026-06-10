<?php

namespace App\Concerns;

trait HasLocalizedSlugs
{
    public function slugForLocale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return (string) ($this->{"slug_{$locale}"} ?? '');
    }
}
