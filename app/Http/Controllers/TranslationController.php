<?php

namespace App\Http\Controllers;

use App\Services\LangFileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TranslationController extends Controller
{
    public function __construct(private LangFileManager $langFiles)
    {
    }

    public function index()
    {
        $groups = collect($this->langFiles->groups())->map(function ($label, $group) {
            return [
                'group' => $group,
                'label' => $label,
                'keys' => count($this->langFiles->keysForGroup($group)),
            ];
        })->values();

        return view('argon.pages.translations.index', compact('groups'));
    }

    public function edit(string $group)
    {
        $label = $this->langFiles->groups()[$group] ?? abort(404);
        $keys = $this->langFiles->keysForGroup($group);
        $values = [];

        foreach (LangFileManager::LOCALES as $locale) {
            $values[$locale] = $this->langFiles->flattenedGroup($group, $locale);
        }

        return view('argon.pages.translations.edit', compact('group', 'label', 'keys', 'values'));
    }

    public function update(Request $request, string $group)
    {
        if (! array_key_exists($group, $this->langFiles->groups())) {
            abort(404);
        }

        $request->validate([
            'rows' => ['required', 'array'],
            'rows.*.key' => ['required', 'string'],
            'rows.*.ka' => ['nullable', 'string'],
            'rows.*.en' => ['nullable', 'string'],
        ]);

        $localeValues = [
            'ka' => [],
            'en' => [],
        ];

        foreach ($request->input('rows', []) as $row) {
            $key = $row['key'];
            $localeValues['ka'][$key] = $row['ka'] ?? '';
            $localeValues['en'][$key] = $row['en'] ?? '';
        }

        $this->langFiles->saveGroup($group, $localeValues);

        if (app()->configurationIsCached()) {
            Artisan::call('config:clear');
        }

        return redirect()
            ->route('translations.edit', ['group' => $group])
            ->withSuccess('Translations updated.');
    }
}
