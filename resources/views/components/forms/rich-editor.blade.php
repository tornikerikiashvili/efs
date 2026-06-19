@props([
    'model',
    'field',
    'record' => null,
    'label' => 'Content',
    'height' => 350,
])

@php
    $modelClass = is_object($model) ? get_class($model) : $model;
    $modelBase = strtolower(class_basename($modelClass));
    $inputName = "{$modelBase}-trixFields[{$field}]";
    $oldKey = "{$modelBase}-trixFields.{$field}";
    $editorId = $modelBase . '-' . str_replace('_', '-', $field) . '-' . (optional($record)->id ?? 'new');

    $storedContent = '';
    if ($record && $record->exists && method_exists($record, 'trixRichText')) {
        $storedContent = optional($record->trixRichText()->where('field', $field)->first())->content ?? '';
    }

    $value = old($oldKey, $storedContent);
    $safeValue = str_replace('</textarea>', '&lt;/textarea&gt;', $value);
@endphp

<div class="form-group rich-editor-field">
    <label class="form-control-label">{{ $label }}</label>
    <textarea
        id="{{ $editorId }}"
        name="{{ $inputName }}"
        class="rich-editor form-control"
        data-height="{{ (int) $height }}"
        style="min-height: {{ (int) $height }}px; width: 100%;"
    >{!! $safeValue !!}</textarea>
</div>

@once
    @push('css')
        <style>
            .rich-editor-field textarea.rich-editor {
                min-height: 200px;
            }

            .rich-editor-field .tox-tinymce {
                border-radius: 0.375rem;
            }
        </style>
    @endpush
@endonce
