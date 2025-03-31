
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
            
            <!-- Product Type Toggle -->
            <div class="mt-4">
                <h5>Product Type</h5>
                <div class="form-group">
                    <label>
                        <input type="radio" name="product_type" value="simple" checked> Simple Product
                    </label>
                    <label class="ms-3">
                        <input type="radio" name="product_type" value="variant"> Product with Variants
                    </label>
                </div>
            </div>
            
            <!-- Basic Info -->
            <div class="mt-4">
                <h5>Basic Info</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label for="category_id">{{ __('cms.products.category') }}</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">{{ __('cms.products.select_category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->translation->name ?? 'Not Available' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="brand_id">{{ __('cms.products.brand') }}</label>
                        <select name="brand_id" id="brand_id" class="form-control">
                            <option value="">{{ __('cms.products.select_brand') }}</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->translation->name ?? 'Not Available' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Pricing & Stock for Simple Products -->
            <div id="simpleProductFields" class="mt-4">
                <h5>Pricing & Stock</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label for="price">{{ __('cms.products.price') }}</label>
                        <input type="number" step="0.01" name="price" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="discount_price">{{ __('cms.products.discount_price') }}</label>
                        <input type="number" step="0.01" name="discount_price" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="stock">{{ __('cms.products.stock') }}</label>
                        <input type="number" name="stock" class="form-control">
                    </div>
                </div>
            </div>
            
            <!-- Variants Section -->
            <div id="variantsContainer" class="mt-4" style="display: none;">
                <h5>Variants</h5>
                <button type="button" class="btn btn-success" id="addVariant">{{ __('cms.products.add_variant') }}</button>
            </div>
            
            <!-- Product Images -->
            <div class="mt-4">
                <h5>Product Images</h5>
                <label for="product_images">{{ __('cms.products.image') }}</label>
                <input type="file" name="product_images[]" accept="image/*" multiple class="form-control">
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
    document.addEventListener("DOMContentLoaded", function () {
        const simpleProductFields = document.getElementById("simpleProductFields");
        const variantsContainer = document.getElementById("variantsContainer");

        document.querySelectorAll('input[name="product_type"]').forEach((radio) => {
            radio.addEventListener("change", function () {
                if (this.value === "simple") {
                    simpleProductFields.style.display = "block";
                    variantsContainer.style.display = "none";
                } else {
                    simpleProductFields.style.display = "none";
                    variantsContainer.style.display = "block";
                }
            });
        });
    });
</script>





<script>

    

    document.getElementById('product_image_file').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var previewElement = document.getElementById('product_image_preview');
        var previewImage = document.getElementById('product_image_preview_img');

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewElement.style.display = 'block';
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            previewElement.style.display = 'none';
        }
    });
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


