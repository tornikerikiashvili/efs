<?php

namespace App\Services;

use Illuminate\Support\Arr;
use InvalidArgumentException;

class SiteSeoManager
{
    public const LOCALES = ['ka', 'en'];

    public const PAGES = [
        'default' => 'Site default (fallback)',
        'home' => 'Homepage',
        'about' => 'About',
        'services' => 'Services',
        'projects' => 'Projects',
        'news' => 'News',
        'blog' => 'Blog',
        'contact' => 'Contact',
    ];

    public const FIELDS = [
        'title' => 'Meta title',
        'description' => 'Meta description',
        'og_title' => 'OG title',
        'og_description' => 'OG description',
        'og_image' => 'OG image URL',
    ];

    public function values(): array
    {
        $values = [];

        foreach (self::LOCALES as $locale) {
            $stored = $this->read($locale);
            $values[$locale] = [];

            foreach (array_keys(self::PAGES) as $pageKey) {
                $values[$locale][$pageKey] = array_merge(
                    array_fill_keys(array_keys(self::FIELDS), ''),
                    Arr::get($stored, $pageKey, [])
                );
            }
        }

        return $values;
    }

    public function read(string $locale): array
    {
        $path = $this->path($locale);

        if (! is_file($path)) {
            return [];
        }

        $lines = include $path;

        return is_array($lines) ? $lines : [];
    }

    public function save(array $localeValues): void
    {
        foreach (self::LOCALES as $locale) {
            $this->write($locale, Arr::get($localeValues, $locale, []));
        }
    }

    protected function write(string $locale, array $lines): void
    {
        $path = $this->path($locale);
        $content = "<?php\n\nreturn ".$this->exportArray($lines).";\n";

        if (file_put_contents($path, $content) === false) {
            throw new InvalidArgumentException("Could not write SEO file: {$path}");
        }
    }

    protected function path(string $locale): string
    {
        if (! in_array($locale, self::LOCALES, true)) {
            throw new InvalidArgumentException("Locale [{$locale}] is not supported.");
        }

        return resource_path("lang/{$locale}/seo.php");
    }

    protected function exportArray(array $array, int $depth = 1): string
    {
        $indent = str_repeat('    ', $depth);
        $items = [];

        foreach ($array as $key => $value) {
            $exportedKey = is_int($key) ? $key : "'".addslashes((string) $key)."'";

            if (is_array($value)) {
                $items[] = $indent.$exportedKey.' => '.$this->exportArray($value, $depth + 1);
            } else {
                $items[] = $indent.$exportedKey." => '".addslashes((string) $value)."'";
            }
        }

        if ($items === []) {
            return '[]';
        }

        $childIndent = str_repeat('    ', $depth - 1);

        return "[\n".implode(",\n", $items).",\n".$childIndent.']';
    }
}
