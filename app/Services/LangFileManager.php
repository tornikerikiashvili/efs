<?php

namespace App\Services;

use Illuminate\Support\Arr;
use InvalidArgumentException;

class LangFileManager
{
    public const LOCALES = ['ka', 'en'];

    public const GROUPS = [
        'menu' => 'Menu',
        'other' => 'Footer & misc',
        'about' => 'About page',
        'homepage' => 'Homepage',
    ];

    public function groups(): array
    {
        return self::GROUPS;
    }

    public function readGroup(string $group, string $locale): array
    {
        $path = $this->path($group, $locale);

        if (! is_file($path)) {
            return [];
        }

        $lines = include $path;

        return is_array($lines) ? $lines : [];
    }

    public function flattenedGroup(string $group, string $locale): array
    {
        return $this->flatten($this->readGroup($group, $locale));
    }

    public function keysForGroup(string $group): array
    {
        $keys = [];

        foreach (self::LOCALES as $locale) {
            $keys = array_merge($keys, array_keys($this->flattenedGroup($group, $locale)));
        }

        sort($keys);

        return array_values(array_unique($keys));
    }

    public function saveGroup(string $group, array $localeValues): void
    {
        foreach (self::LOCALES as $locale) {
            $flat = Arr::get($localeValues, $locale, []);
            $nested = $this->unflatten($flat);
            $this->writeGroup($group, $locale, $nested);
        }
    }

    public function writeGroup(string $group, string $locale, array $lines): void
    {
        $path = $this->path($group, $locale);
        $content = "<?php\n\nreturn ".$this->exportArray($lines).";\n";

        if (file_put_contents($path, $content) === false) {
            throw new InvalidArgumentException("Could not write translation file: {$path}");
        }
    }

    public function flatten(array $array, string $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $fullKey = $prefix === '' ? (string) $key : $prefix.'.'.$key;

            if (is_array($value)) {
                $result = array_merge($result, $this->flatten($value, $fullKey));
            } else {
                $result[$fullKey] = (string) $value;
            }
        }

        return $result;
    }

    public function unflatten(array $flat): array
    {
        $result = [];

        foreach ($flat as $key => $value) {
            Arr::set($result, $key, $value);
        }

        return $result;
    }

    protected function path(string $group, string $locale): string
    {
        $this->assertGroup($group);
        $this->assertLocale($locale);

        return resource_path("lang/{$locale}/{$group}.php");
    }

    protected function assertGroup(string $group): void
    {
        if (! array_key_exists($group, self::GROUPS)) {
            throw new InvalidArgumentException("Translation group [{$group}] is not manageable.");
        }
    }

    protected function assertLocale(string $locale): void
    {
        if (! in_array($locale, self::LOCALES, true)) {
            throw new InvalidArgumentException("Locale [{$locale}] is not supported.");
        }
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
                $items[] = $indent.$exportedKey." => '".$this->escapePhpSingleQuotedString((string) $value)."'";
            }
        }

        if ($items === []) {
            return '[]';
        }

        $childIndent = str_repeat('    ', $depth - 1);

        return "[\n".implode(",\n", $items).",\n".$childIndent.']';
    }

    protected function escapePhpSingleQuotedString(string $value): string
    {
        return str_replace(['\\', "'"], ['\\\\', "\\'"], $value);
    }
}
