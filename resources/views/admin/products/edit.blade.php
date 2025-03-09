{{--

@extends('admin.layouts.admin')

@section('content')
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.products.heading') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- This method will simulate a PUT request for updating -->

                <div class="row">
                    <!-- Category Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">{{ __('cms.products.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="" disabled>{{ __('cms.products.select_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Type Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_type">{{ __('cms.products.product_type') }}</label>
                            <select name="product_type" id="product_type" class="form-control" required>
                                <option value="" disabled>Select Product Type</option>
                                <option value="physical" {{ old('product_type', $product->product_type) == 'physical' ? 'selected' : '' }}>{{ __('cms.products.physical') }}</option>
                                <option value="digital" {{ old('product_type', $product->product_type) == 'digital' ? 'selected' : '' }}>{{ __('cms.products.digital') }}</option>
                                <option value="service" {{ old('product_type', $product->product_type) == 'service' ? 'selected' : '' }}>{{ __('cms.products.service') }}</option>
                            </select>
                            @error('product_type')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Price Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">{{ __('cms.products.price') }}</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock">{{ __('cms.products.stock') }}</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Currency Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="currency">{{ __('cms.products.currency') }}</label>
                            <input type="text" name="currency" id="currency" class="form-control" value="{{ old('currency', $product->currency) }}" required>
                            @error('currency')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SKU Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="SKU">{{ __('cms.products.sku') }}</label>
                            <input type="text" name="SKU" id="SKU" class="form-control" value="{{ old('SKU', $product->SKU) }}" required>
                            @error('SKU')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Weight Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="weight">{{ __('cms.products.weight') }}</label>
                            <input type="number" step="0.01" name="weight" id="weight" class="form-control" value="{{ old('weight', $product->weight) }}">
                            @error('weight')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dimensions Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dimensions">{{ __('cms.products.dimensions') }}</label>
                            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ old('dimensions', $product->dimensions) }}">
                            @error('dimensions')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Product Image Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image_url">{{ __('cms.products.image_preview') }}</label>
                            <button type="button" id="image_button" class="btn btn-secondary">{{ __('cms.products.image_select') }}</button>
                            <input type="file" id="image_file" name="image_url" accept="image/*" style="display:none;">
                            
                            <!-- Hidden input field for the image URL -->
                            <input type="hidden" name="image_url" id="image_url" value="{{ old('image_url', $imageUrl) }}">
                            
                            <!-- Display the image preview if the product has an image -->
                            <div class="mt-2" id="image_preview" style="display:{{ $imageUrl ? 'block' : 'none' }};">
                                <img id="image_preview_img" 
                                    src="{{ old('image_url', $imageUrl ? asset($imageUrl) : '') }}" 
                                    alt="Selected Image" class="img-thumbnail" width="100">
                            </div>                                               
                            @error('image_url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @foreach($activeLanguages as $language)
                    <div class="border p-3 mb-3 rounded-3"> <!-- Light border and padding -->

                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="name_{{ $language->code }}" class="form-label">{{ __('cms.products.name') }} ({{ $language->name }})</label>
                            <input type="text" 
                                   value="{{ old('translations.' . $language->code . '.name', $product->getTranslation('name', $language->code)) }}" 
                                   name="translations[{{ $language->code }}][name]" 
                                   id="name_{{ $language->code }}" 
                                   class="form-control @error('translations.' . $language->code . '.name') is-invalid @enderror" 
                                   required>
                            @error('translations.' . $language->code . '.name') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
    
                        <!-- Category Description -->
                        <div class="mb-3">
                            <label for="description_{{ $language->code }}" class="form-label">{{ __('cms.products.description') }} ({{ $language->name }})</label>
                            <textarea name="translations[{{ $language->code }}][description]" 
                                      id="description_{{ $language->code }}" 
                                      class="form-control @error('translations.' . $language->code . '.description') is-invalid @enderror">
                                {{ old('translations.' . $language->code . '.description', $product->getTranslation('description', $language->code)) }}
                            </textarea>                   
                            @error('translations.' . $language->code . '.description') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
    
                    </div>
                    @endforeach

                </div>

                <!-- Submit Button -->
                <button type="submit" class="mt-3 btn btn-primary">{{ __('cms.products.update_product') }}</button>
            </form>
        </div>
    </div>
    <script>
        // Trigger the file input when the "Select Image" button is clicked
        document.getElementById('image_button').addEventListener('click', function() {
            document.getElementById('image_file').click();
        });

        // Handle the image file selection and preview
        document.getElementById('image_file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageUrl = e.target.result;
                    document.getElementById('image_url').value = imageUrl; // Store the image URL in the hidden field
                    document.getElementById('image_preview').style.display = 'block';
                    document.getElementById('image_preview_img').src = imageUrl; // Show the preview of the selected image
                };
                reader.readAsDataURL(file); // Convert the image file to Base64
            }
        });
    </script>
@endsection


--}}


@extends('admin.layouts.admin')
@section('content')
    <div class="card mt-4">
        <div class="card-header card-header-bg text-white">
            <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.products.heading') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">{{ __('cms.products.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="" disabled>{{ __('cms.products.select_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_type">{{ __('cms.products.product_type') }}</label>
                            <select name="product_type" id="product_type" class="form-control" required>
                                <option value="physical" {{ $product->product_type == 'physical' ? 'selected' : '' }}>{{ __('cms.products.physical') }}</option>
                                <option value="digital" {{ $product->product_type == 'digital' ? 'selected' : '' }}>{{ __('cms.products.digital') }}</option>
                                <option value="service" {{ $product->product_type == 'service' ? 'selected' : '' }}>{{ __('cms.products.service') }}</option>
                            </select>
                        </div>
                    </div>
                    
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
                            <input type="text" name="translations[{{ $language->code }}][name]" class="form-control" value="{{ $product->getTranslation('name', $language->code) }}" required>
                            <label class="form-label">{{ __('cms.products.description') }} ({{ $language->code }})</label>
                            <textarea name="translations[{{ $language->code }}][description]" class="form-control ck-editor-multi-languages">{{ $product->getTranslation('description', $language->code) }}</textarea>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">{{ __('cms.products.price') }}</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="weight">{{ __('cms.products.weight') }}</label>
                            <input type="text" name="weight" id="weight" class="form-control" value="{{ $product->weight }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dimensions">{{ __('cms.products.dimensions') }}</label>
                            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ $product->dimensions }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="currency">{{ __('cms.products.currency') }}</label>
                            <input type="text" name="currency" id="currency" class="form-control" value="{{ $product->currency }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock">{{ __('cms.products.stock') }}</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="SKU">{{ __('cms.products.sku') }}</label>
                            <input type="text" name="SKU" id="SKU" class="form-control" value="{{ $product->SKU }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image_url">{{ __('cms.products.image_preview') }}</label>
                            <input type="file" name="image_url" id="image_url" class="form-control" accept="image/*">
                            <img src="{{ asset($product->image_url) }}" id="product_image_preview" class="mt-2" width="100" style="display:block;"> 
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="col-md-12 text-start">
                <div class="d-inline-block">
                    <button type="submit" class="mt-3 btn btn-primary btn-sm">{{ __('cms.products.update_product') }}</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.getElementById('image_url').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var previewElement = document.getElementById('product_image_preview');

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block';
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

