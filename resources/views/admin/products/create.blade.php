@extends('admin.layouts.admin')
@section('content')

<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.products.title_create') }}</h6>
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
            
            {{-- Language Tabs --}}
            <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                @foreach($activeLanguages as $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                id="{{ $language->code }}-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#{{ $language->code }}" 
                                type="button" 
                                role="tab">
                            {{ ucwords($language->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>
     
            <div class="tab-content mt-3" id="languageTabContent">
                @foreach($activeLanguages as $language)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" 
                         id="{{ $language->code }}" 
                         role="tabpanel">
                        
                        {{-- Product Name --}}
                        <label class="form-label">{{ __('cms.products.product_name') }} ({{ $language->code }})</label>
                        <input type="text"
                               name="translations[{{ $language->code }}][name]"
                               class="form-control @error("translations.{$language->code}.name") is-invalid @enderror"
                               value="{{ old("translations.{$language->code}.name") }}"
                               required>
                        @error("translations.{$language->code}.name")
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
            
                        {{-- Description --}}
                        <label class="form-label mt-3">{{ __('cms.products.description') }} ({{ $language->code }})</label>
                        <textarea name="translations[{{ $language->code }}][description]"
                                  class="form-control ck-editor-multi-languages @error("translations.{$language->code}.description") is-invalid @enderror">{{ old("translations.{$language->code}.description") }}</textarea>
                        @error("translations.{$language->code}.description")
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>
                       
            {{-- Category & Brand --}}
            <div class="row mt-4">
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.products.category') }}</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->translation->name ?? '—' }}
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
                                {{ $brand->translation->name ?? '—' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Vendor --}}
            <div class="row mt-4">
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.products.vendor') }}</label>
                    <select name="vendor_id" class="form-control" required>
                        <option value="">{{ __('cms.products.select_vendor') }}</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Variants --}}
            <div id="variants-wrapper" class="mt-3"></div>

            <div class="d-flex gap-2 mt-3">
                <button type="button" class="btn btn-sm btn-primary" id="add-variant-btn">
                    {{ __('cms.products.add_variant') }}
                </button> 
                <button type="button" class="btn btn-sm btn-danger" id="remove-variant-btn" disabled>
                    {{ __('cms.products.remove_variant') ?? 'Remove Variant' }}
                </button>
            </div> 
                   
            <template id="variant-template">
                <div class="card p-3 mt-3 variant-item border rounded" data-index="__INDEX__">
                    <h5>{{ __('cms.products.variants') }} <span class="variant-number">__INDEX__</span></h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{ __('cms.products.variant_name_en') }}</label>
                            <input type="text" name="variants[__INDEX__][name]" class="form-control" value="__NAME__" />
                        </div>
                        <div class="col-md-4">
                            <label>{{ __('cms.products.price') }}</label>
                            <input type="number" step="0.01" name="variants[__INDEX__][price]" class="form-control" value="__PRICE__" />
                        </div>
                        <div class="col-md-4">
                            <label>{{ __('cms.products.discount_price') }}</label>
                            <input type="number" step="0.01" name="variants[__INDEX__][discount_price]" class="form-control" value="__DISCOUNT__" />
                        </div>
            
                        <div class="col-md-4 mt-2">
                            <label>{{ __('cms.products.stock') }}</label>
                            <input type="number" name="variants[__INDEX__][stock]" class="form-control" value="__STOCK__" />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>{{ __('cms.products.sku') }}</label>
                            <input type="text" name="variants[__INDEX__][SKU]" class="form-control" value="__SKU__" />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>{{ __('cms.products.barcode') }}</label>
                            <input type="text" name="variants[__INDEX__][barcode]" class="form-control" value="__BARCODE__" />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>{{ __('cms.products.weight') }}</label>
                            <input type="text" name="variants[__INDEX__][weight]" class="form-control" placeholder="e.g., 1.5 kg" value="__WEIGHT__" />
                        </div>
                        
                        <div class="col-md-4 mt-2">
                            <label>{{ __('cms.products.dimension') }}</label>
                            <input type="text" name="variants[__INDEX__][dimension]" class="form-control" placeholder="e.g., 10x20x5 cm" value="__DIMENSION__" />
                        </div>
                           
                        <div class="col-md-6 mt-2">
                            <label>{{ __('cms.products.size') }}</label>
                            <select name="variants[__INDEX__][size_id]" class="form-control">
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}" __SIZE_SELECTED__>{{ $size->value }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="col-md-6 mt-2">
                            <label>{{ __('cms.products.color') }}</label>
                            <select name="variants[__INDEX__][color_id]" class="form-control">
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}" __COLOR_SELECTED__>{{ $color->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Images --}}
            <div class="mt-3">
                <label class="form-label">{{ __('cms.products.images') }}</label>
                <div class="custom-file">
                    <label class="btn btn-primary" for="productImages">{{ __('cms.products.choose_file') }}</label>
                    <input type="file" name="images[]" class="form-control d-none" id="productImages" multiple onchange="previewMultipleImages(this)">
                </div>

                <div id="productImagesPreview" class="mt-2 d-flex flex-wrap"></div>
            </div>  
         
            {{-- Submit --}}
            <div class="mt-4 text-start">
                <button type="submit" class="btn btn-primary">{{ __('cms.products.save_product') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    let variantIndex = 0;

    function updateRemoveButtonState() {
        const count = $('#variants-wrapper .variant-item').length;
        $('#remove-variant-btn').prop('disabled', count === 0);
    }

    function addVariant(variant = {}) {
        let template = $('#variant-template').html();
        template = template
            .replace(/__INDEX__/g, variantIndex)
            .replace(/__NAME__/g, variant.name || '')
            .replace(/__PRICE__/g, variant.price || '')
            .replace(/__DISCOUNT__/g, variant.discount_price || '')
            .replace(/__STOCK__/g, variant.stock || '')
            .replace(/__SKU__/g, variant.SKU || '')   
            .replace(/__BARCODE__/g, variant.barcode || '')
            .replace(/__WEIGHT__/g, variant.weight || '')
            .replace(/__DIMENSION__/g, variant.dimension || '')
            .replace(/__SIZE_SELECTED__/g, '')
            .replace(/__COLOR_SELECTED__/g, '');

        const $variant = $(template);

        if (variant.size_id) {
            $variant.find(`select[name="variants[${variantIndex}][size_id]"] option[value="${variant.size_id}"]`).attr('selected', 'selected');
        }
        if (variant.color_id) {
            $variant.find(`select[name="variants[${variantIndex}][color_id]"] option[value="${variant.color_id}"]`).attr('selected', 'selected');
        }

        $('#variants-wrapper').append($variant);
        variantIndex++;
        updateRemoveButtonState();
    }

    $('#add-variant-btn').click(function () {
        addVariant();
    });

    $('#remove-variant-btn').click(function () {
        const $variants = $('#variants-wrapper .variant-item');
        if ($variants.length > 0) {
            $variants.last().remove();
            variantIndex--;
            updateRemoveButtonState();
        }
    });

    $(document).ready(function () {
        @if(old('variants'))
            let oldVariants = @json(old('variants'));
            oldVariants.forEach(v => addVariant(v));
        @else
            addVariant(); 
        @endif
    });
</script>

{{-- Image Preview --}}
<script>
   let selectedFiles = [];

function previewMultipleImages(input) {
    const files = Array.from(input.files);

    files.forEach(file => {
        const uniqueId = file.name + '_' + file.size;
        if (!selectedFiles.some(f => f.uniqueId === uniqueId)) {
            file.uniqueId = uniqueId;
            selectedFiles.push(file);
        }
    });

    const previewContainer = document.getElementById('productImagesPreview');
    previewContainer.innerHTML = '';

    selectedFiles.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = 'position-relative m-1';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.maxWidth = '150px';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerHTML = '&times;';
            removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
            removeBtn.onclick = function() {
                selectedFiles = selectedFiles.filter(f => f.uniqueId !== file.uniqueId);
                updateFileInput(input);
                previewMultipleImages(input);
            };

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });

    updateFileInput(input);
}

function updateFileInput(input) {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
}
</script>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.querySelectorAll('.ck-editor-multi-languages').forEach((element) => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endsection