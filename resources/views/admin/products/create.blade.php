
{{--
@extends('admin.layouts.admin')

@section('content')
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.products.heading') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Category Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">{{ __('cms.products.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="" disabled>{{ __('cms.products.select_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                <option value="" disabled>{{ __('cms.products.select_product_type') }}</option>
                                <option value="physical" {{ old('product_type') == 'physical' ? 'selected' : '' }}>{{ __('cms.products.physical') }}</option>
                                <option value="digital" {{ old('product_type') == 'digital' ? 'selected' : '' }}>{{ __('cms.products.digital') }}</option>
                                <option value="service" {{ old('product_type') == 'service' ? 'selected' : '' }}>{{ __('cms.products.service') }}</option>
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
                            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock">{{ __('cms.products.stock') }}</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" required>
                            @error('stock')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Currency Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="currency">{{ __('cms.products.currency') }}</label>
                            <input type="text" name="currency" id="currency" class="form-control" value="{{ old('currency') }}" required>
                            @error('currency')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SKU Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="SKU">{{ __('cms.products.sku') }}</label>
                            <input type="text" name="SKU" id="SKU" class="form-control" value="{{ old('SKU') }}" required>
                            @error('SKU')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Weight Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="weight">{{ __('cms.products.weight') }}</label>
                            <input type="number" step="0.01" name="weight" id="weight" class="form-control" value="{{ old('weight') }}">
                            @error('weight')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dimensions Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dimensions">{{ __('cms.products.dimensions') }}</label>
                            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ old('dimensions') }}">
                            @error('dimensions')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image_url">{{ __('cms.products.image_preview') }}</label>
                            <button type="button" id="image_button" class="btn btn-secondary">{{ __('cms.products.image_select') }}</button>
                            <input type="file" id="image_file" name="image_url" accept="image/*" style="display:none;">
                            <input type="hidden" name="image_url" id="image_url" value="{{ old('image_url') }}">
                            
                            <div class="mt-2" id="image_preview" style="display:none;">
                                <img id="image_preview_img" src="#" alt="Selected Image" class="img-thumbnail" width="100">
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
                                   value="{{ old('translations.' . $language->code . '.name') }}" 
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
                                {{ old('translations.' . $language->code . '.description') }}
                            </textarea>                  
                            @error('translations.' . $language->code . '.description') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
    
                    </div>
                    @endforeach

                </div>

                <!-- Submit Button -->
                <button type="submit" class="mt-3 btn btn-primary">{{ __('cms.products.save') }}</button>
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
                    document.getElementById('image_preview_img').src = imageUrl;
                };
                reader.readAsDataURL(file);
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">{{ __('cms.products.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="" disabled>{{ __('cms.products.select_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_type">{{ __('cms.products.product_type') }}</label>
                            <select name="product_type" id="product_type" class="form-control" required>
                                <option value="" disabled>{{ __('cms.products.select_product_type') }}</option>
                                <option value="physical" {{ old('product_type') == 'physical' ? 'selected' : '' }}>{{ __('cms.products.physical') }}</option>
                                <option value="digital" {{ old('product_type') == 'digital' ? 'selected' : '' }}>{{ __('cms.products.digital') }}</option>
                                <option value="service" {{ old('product_type') == 'service' ? 'selected' : '' }}>{{ __('cms.products.service') }}</option>
                            </select>
                            @error('product_type')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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
                                <input type="text" name="translations[{{ $language->code }}][name]" class="form-control" required>
                                <label class="form-label">{{ __('cms.products.description') }} ({{ $language->code }})</label>
                                <textarea name="translations[{{ $language->code }}][description]" class="form-control ck-editor-multi-languages"></textarea>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">{{ __('cms.products.price') }}</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="weight">{{ __('cms.products.weight') }}</label>
                            <input type="text" name="weight" id="weight" class="form-control" value="{{ old('weight') }}" required>
                            @error('weight')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock">{{ __('cms.products.stock') }}</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" required>
                            @error('stock')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="currency">{{ __('cms.products.currency') }}</label>
                            <input type="text" name="currency" id="currency" class="form-control" value="{{ old('currency') }}" required>
                            @error('currency')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dimensions">{{ __('cms.products.dimensions') }}</label>
                            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ old('dimensions') }}" required>
                            @error('dimensions')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                    <!-- SKU Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="SKU">{{ __('cms.products.sku') }}</label>
                            <input type="text" name="SKU" id="SKU" class="form-control" value="{{ old('SKU') }}" required>
                            @error('SKU')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image_type">{{ __('cms.products.image_type') }}</label>
                            <select name="image_type" id="image_type" class="form-control" required>
                                <option value="thumb" {{ old('image_type') == 'thumb' ? 'selected' : '' }}>{{ __('cms.products.thumbnail') }}</option>
                                <option value="slide" {{ old('image_type') == 'slide' ? 'selected' : '' }}>{{ __('cms.products.slide') }}</option>
                            </select>
                            @error('image_type')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image_url">{{ __('cms.products.image_preview') }}</label>
                            <input type="file" name="image_url" id="image_url" class="form-control" accept="image/*">
                            @error('image_url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-start">
                    <button type="submit" class="mt-3 btn btn-primary">{{ __('cms.products.save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
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
