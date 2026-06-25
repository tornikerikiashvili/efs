@props(['record' => null])

<div class="row mt-3">
    <div class="col-md-6">
        <x-forms.input type="text" name="image_alt_ka" headline="Image alt text (Georgian)" value="{{ data_get($record, 'image_alt_ka') ?? old('image_alt_ka') }}" />
    </div>
    <div class="col-md-6">
        <x-forms.input type="text" name="image_alt_en" headline="Image alt text (English)" value="{{ data_get($record, 'image_alt_en') ?? old('image_alt_en') }}" />
    </div>
</div>
