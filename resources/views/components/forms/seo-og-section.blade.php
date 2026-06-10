@props(['locale', 'record' => null])

@php
    $metaTitleField = 'meta_title_' . $locale;
    $metaDescriptionField = 'meta_description_' . $locale;
    $ogTitleField = 'og_title_' . $locale;
    $ogDescriptionField = 'og_description_' . $locale;
@endphp

<div class="seo-og-section mb-4 p-3 rounded border" style="background-color: #f6f7ff;">
    <h6 class="heading-small text-muted mb-3">SEO & OG</h6>

    <x-forms.input
        type="text"
        :name="$metaTitleField"
        headline="Meta Title"
        :value="data_get($record, $metaTitleField) ?? old($metaTitleField)"
    />
    <x-forms.input
        type="text"
        :name="$metaDescriptionField"
        headline="Meta Description"
        :value="data_get($record, $metaDescriptionField) ?? old($metaDescriptionField)"
    />
    <x-forms.input
        type="text"
        :name="$ogTitleField"
        headline="OG Title"
        :value="data_get($record, $ogTitleField) ?? old($ogTitleField)"
    />
    <x-forms.input
        type="text"
        :name="$ogDescriptionField"
        headline="OG Description"
        :value="data_get($record, $ogDescriptionField) ?? old($ogDescriptionField)"
    />
</div>
