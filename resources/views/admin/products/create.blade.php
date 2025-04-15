



@extends('admin.layouts.admin')
@section('content')

<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.products.heading') }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Multilingual Product Name & Description -->
            <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                @foreach($activeLanguages as $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $language->name }}" type="button" role="tab">{{ ucwords($language->name) }}</button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content mt-3" id="languageTabContent">
                @foreach($activeLanguages as $language)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}" role="tabpanel">
                        <label class="form-label">{{ __('cms.products.name') }} ({{ $language->code }})</label>
                        <input type="text" name="translations[{{ $language->code }}][name]" class="form-control" required>
                        <label class="form-label">{{ __('cms.products.description') }} ({{ $language->code }})</label>
                        <textarea name="translations[{{ $language->code }}][description]" class="form-control ck-editor-multi-languages"></textarea>
                    </div>
                @endforeach
            </div>
            
            <!-- Product Details -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.products.category') }}</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->translation->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.products.brand') }}</label>
                    <select name="brand_id" class="form-control">
                        <option value="">{{ __('cms.products.no_brand') }}</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->translation->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Product Variants NEW -->
            <div id="variants-wrapper">
                <!-- Variants will be appended here -->
            </div>

            <button type="button" class="btn btn-sm btn-primary mt-3" id="add-variant-btn">
                Add Variant
            </button>


            <template id="variant-template">
                <div class="card p-3 mt-3 variant-item border rounded" data-index="__INDEX__">
                    <h5>Variant <span class="variant-number">__INDEX__</span></h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Variant Name (EN)</label>
                            <input type="text" name="variants[__INDEX__][name]" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label>Price</label>
                            <input type="number" step="0.01" name="variants[__INDEX__][price]" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label>Discount Price</label>
                            <input type="number" step="0.01" name="variants[__INDEX__][discount_price]" class="form-control" />
                        </div>
            
                        <div class="col-md-4 mt-2">
                            <label>Stock</label>
                            <input type="number" name="variants[__INDEX__][stock]" class="form-control" />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>SKU</label>
                            <input type="text" name="variants[__INDEX__][SKU]" class="form-control" />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>Barcode</label>
                            <input type="text" name="variants[__INDEX__][barcode]" class="form-control" />
                        </div>
            
                        <div class="col-md-6 mt-2">
                            <label>Size</label>
                            <select name="variants[__INDEX__][size_id]" class="form-control">
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->value }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="col-md-6 mt-2">
                            <label>Color</label>
                            <select name="variants[__INDEX__][color_id]" class="form-control">
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </template>
            

            <!-- Product Images -->
            <div class="mt-3">
                <label class="form-label">{{ __('cms.products.images') }}</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>
            
            <!-- Submit Button -->
            <div class="mt-4 text-start">
                <button type="submit" class="btn btn-primary">{{ __('cms.products.save') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    let variantIndex = 0;

    $('#add-variant-btn').click(function () {
        const template = $('#variant-template').html().replaceAll('__INDEX__', variantIndex);
        $('#variants-wrapper').append(template);
        variantIndex++;
    });
</script>









<script>
    /*
$(document).ready(function () {
    let variantIndex = 0;
    $('#add-variant').click(function () {
        let variantHTML = `<div class="variant-group mt-3">
                <div class="row">
                    @foreach($activeLanguages as $language)
                        <div class="col-md-4">
                            <label class="form-label">Variant Name ({{ $language->code }})</label>
                            <input type="text" name="variants[${variantIndex}][translations][{{ $language->code }}][name]" class="form-control" required>
                        </div>
                    @endforeach
                    <div class="col-md-4">
                        <label class="form-label">Price</label>
                        <input type="number" name="variants[${variantIndex}][price]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stock</label>
                        <input type="number" name="variants[${variantIndex}][stock]" class="form-control" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">SKU</label>
                        <input type="text" name="variants[${variantIndex}][SKU]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Barcode</label>
                        <input type="text" name="variants[${variantIndex}][barcode]" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Weight</label>
                        <input type="number" name="variants[${variantIndex}][weight]" class="form-control">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Dimensions</label>
                        <input type="text" name="variants[${variantIndex}][dimensions]" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Is Primary</label>
                        <input type="checkbox" name="variants[${variantIndex}][is_primary]" value="1" class="form-check-input">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Variant Images</label>
                        <input type="file" name="variants[${variantIndex}][images][]" class="form-control" multiple>
                    </div>
                </div>
            </div>`;
        $('#variant-container').append(variantHTML);
        variantIndex++;
    });

    $('#product_type').change(function () {
        if ($(this).val() === 'variable') {
            $('#variant-fields').show();
        } else {
            $('#variant-fields').hide();
            $('#variant-container').empty();
        }
    });
});*/
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    // Select all elements with the class 'ck-editor-multi-languages' and apply CKEditor to each
    document.querySelectorAll('.ck-editor-multi-languages').forEach((element) => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endsection 











{{--


@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.products.heading') }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Multilingual Product Name & Description -->
            <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                @foreach($activeLanguages as $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $language->name }}" type="button" role="tab">
                            {{ ucwords($language->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content mt-3" id="languageTabContent">
                @foreach($activeLanguages as $language)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}" role="tabpanel">
                        <label class="form-label">{{ __('cms.products.name') }} ({{ $language->code }})</label>
                        <input type="text" name="translations[{{ $language->code }}][name]" class="form-control" value="{{ old('translations.' . $language->code . '.name') }}" required>

                        <label class="form-label mt-2">{{ __('cms.products.description') }} ({{ $language->code }})</label>
                        <textarea name="translations[{{ $language->code }}][description]" class="form-control ck-editor-multi-languages">{{ old('translations.' . $language->code . '.description') }}</textarea>
                    </div>
                @endforeach
            </div>

            <!-- Product Details -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.products.category') }}</label>
                    <select name="category_id" class="form-control">
                        <option value="">{{ __('cms.products.select_category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->translation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.products.brand') }}</label>
                    <select name="brand_id" class="form-control">
                        <option value="">{{ __('cms.products.no_brand') }}</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->translation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label">{{ __('cms.products.slug') }}</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
            </div>

            <!-- Product Type -->
            <div class="mt-3">
                <label class="form-label">{{ __('cms.products.product_type') }}</label>
                <select name="product_type" class="form-control" id="product_type" required>
                    <option value="simple" {{ old('product_type') == 'simple' ? 'selected' : '' }}>Simple</option>
                    <option value="variable" {{ old('product_type') == 'variable' ? 'selected' : '' }}>Variable</option>
                </select>
            </div>

            <!-- Product Variants by Size and Color -->
            <div id="variant-fields" class="mt-4" style="display:none;">
                <h5>Product Variants</h5>
                @foreach(['small', 'medium', 'large'] as $size)
                    <div class="variant-group mt-3 border p-3 rounded shadow-sm">
                        <h6 class="text-capitalize">{{ $size }} Size Variants</h6>
                        <div id="{{ $size }}-variants-container"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-color-variant" data-size="{{ $size }}">Add Color Variant</button>
                    </div>
                @endforeach
            </div>

            <!-- Product Attributes -->
            <div class="form-group mt-4">
                <label for="attributes">Attributes</label>
                <div class="row">
                    @foreach($attributes as $index => $attribute)
                        <div class="col-6">
                            <div class="attribute-group">
                                <label>{{ $attribute->name }}</label>
                                <select name="attributes[{{ $attribute->id }}]" class="form-control" required>
                                    <option value="">{{ __('cms.products.select') }} {{ $attribute->name }}</option>
                                    @foreach($attribute->values as $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->translations->where('language_code', app()->getLocale())->first()->translated_value ?? $value->value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if (($index + 1) % 2 == 0)</div><div class="row">@endif
                    @endforeach
                </div>
            </div>

            <!-- Product Images -->
            <div class="mt-3">
                <label class="form-label">{{ __('cms.products.images') }}</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>

            <!-- Submit Button -->
            <div class="mt-4 text-start">
                <button type="submit" class="btn btn-primary">{{ __('cms.products.save') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    const languages = @json($languages);
    const attributeSizeMap = @json($attributeSizeMap); // Mapping for size ids
    let variantCounters = { small: 0, medium: 0, large: 0 };

    $('.add-color-variant').click(function () {
        let size = $(this).data('size');
        let index = variantCounters[size]++;
        let colorInputs = '';
        let hiddenColorInput = '';

        languages.forEach(lang => {
            const inputName = `variants[${size}][${index}][translations][${lang.code}][name]`;
            colorInputs += `  
                <input type="text" name="${inputName}" class="form-control mb-1 color-input"
                       data-lang="${lang.code}" data-size="${size}" data-index="${index}"
                       placeholder="Color in ${lang.name}" required>`;
            if (lang.code === 'en') {
                hiddenColorInput = `<input type="hidden" name="variants[${size}][${index}][color]"
                                         class="color-hidden" data-size="${size}" data-index="${index}">`;
            }
        });

        const html = `
            <div class="color-variant-group border p-2 mb-2">
                <div class="row">
                    <div class="col-md-3">
                        <label>Color Name</label>
                        ${colorInputs}
                        ${hiddenColorInput}
                        <input type="hidden" name="variants[${size}][${index}][attributes][size]" value="${attributeSizeMap[size]}">
                        <input type="hidden" class="color-attribute-id" name="variants[${size}][${index}][attributes][color]" value="">
                    </div>
                    <div class="col-md-2"><label>Price</label><input type="number" step="0.01" name="variants[${size}][${index}][price]" class="form-control" required></div>
                    <div class="col-md-2"><label>Stock</label><input type="number" name="variants[${size}][${index}][stock]" class="form-control" required></div>
                    <div class="col-md-2"><label>SKU</label><input type="text" name="variants[${size}][${index}][SKU]" class="form-control"></div>
                    <div class="col-md-3"><label>Images</label><input type="file" name="variants[${size}][${index}][images][]" class="form-control" multiple></div>
                    <div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-danger remove-variant">X</button></div>
                </div>
            </div>`;

        $(`#${size}-variants-container`).append(html);
    });

    $(document).on('click', '.remove-variant', function () {
        $(this).closest('.color-variant-group').remove();
    });

    $(document).on('input', '.color-input[data-lang="en"]', function () {
        const size = $(this).data('size');
        const index = $(this).data('index');
        const color = $(this).val();
        $(`input.color-hidden[data-size="${size}"][data-index="${index}"]`).val(color);
    });

    $('#product_type').change(function () {
        if ($(this).val() === 'variable') {
            $('#variant-fields').show();
        } else {
            $('#variant-fields').hide();
            $('.variant-group').find('div[id$="-variants-container"]').empty();
        }
    });

    $(document).ready(function () {
        if ($('#product_type').val() === 'variable') {
            $('#variant-fields').show();
        }
    });

    ClassicEditor.create(document.querySelector('.ck-editor-multi-languages')).catch(error => {
        console.error(error);
    });
</script>
@endsection
--}}