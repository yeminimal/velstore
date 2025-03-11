{{--
@extends('admin.layouts.admin')

@section('title', 'Edit Banner Translations')

@section('content')
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.banners.edit_banner') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- This specifies that the form is for an UPDATE request -->

                <input type="hidden" name="banner_id" value="{{ $banner->id }}">

                <!-- Banner Type Select (appears only once) -->
                <div class="form-group">
                    <label for="type">{{ __('cms.banners.banner_type') }}</label>
                    <select name="type" class="form-control" required>
                        <option value="promotion" {{ $banner->type == 'promotion' ? 'selected' : '' }}>{{ __('cms.banners.promotion') }}</option>
                        <option value="sale" {{ $banner->type == 'sale' ? 'selected' : '' }}>{{ __('cms.banners.sale') }}</option>
                        <option value="seasonal" {{ $banner->type == 'seasonal' ? 'selected' : '' }}>{{ __('cms.banners.seasonal') }}</option>
                        <option value="featured" {{ $banner->type == 'featured' ? 'selected' : '' }}>{{ __('cms.banners.featured') }}</option>
                        <option value="announcement" {{ $banner->type == 'announcement' ? 'selected' : '' }}>{{ __('cms.banners.announcement') }}</option>
                    </select>
                </div>

                <!-- Loop through active languages and create fields for title, image_title, and image -->
                <div id="languages-container">
                    @foreach($languages as $index => $language)
                        <div class="language-section">
                            
                            <!-- Title Input -->
                            <div class="form-group">
                                <label for="languages[{{ $index }}][title]">{{ __('cms.banners.title') }}</label>
                                <input type="text" name="languages[{{ $index }}][title]" 
                                       class="form-control @error('languages.' . $index . '.title') is-invalid @enderror"
                                       value="{{ $translations[$language->code]->title ?? '' }}" required>
                                @error('languages.' . $index . '.title') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <!-- Image Title Input -->
                            <div class="form-group">
                                <label for="languages[{{ $index }}][image_title]">{{ __('cms.banners.image_title') }}</label>
                                <input type="text" name="languages[{{ $index }}][image_title]" 
                                       class="form-control @error('languages.' . $index . '.image_title') is-invalid @enderror"
                                       value="{{ $translations[$language->code]->title ?? '' }}">
                                @error('languages.' . $index . '.image_title') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <!-- Image Input -->
                            <div class="form-group">
                                <label for="languages[{{ $index }}][image]">{{ __('cms.banners.image') }}</label>
                                <div class="custom-file">
                                    <input type="file" name="languages[{{ $index }}][image]" id="languages[{{ $index }}][image]" class="form-control d-none" onchange="displayFileName(this)">
                                    <label class="btn btn-primary" for="languages[{{ $index }}][image]">{{ __('cms.banners.choose_file') }}</label>
                                    <span id="file-name-{{ $index }}" class="ml-2">
                                        @if (isset($translations[$language->code]) && $translations[$language->code]->image_url)
                                            {{ basename($translations[$language->code]->image_url) }}
                                        @endif
                                    </span>
                                </div>
                                @error('languages.' . $index . '.image') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <!-- Hidden language_code input for each language -->
                            <input type="hidden" name="languages[{{ $index }}][language_code]" value="{{ $language->code }}">
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary mt-3">{{ __('cms.banners.save') }}</button>
            </form>
        </div>
    </div>

    <script>
        // Display file name when a file is selected
        function displayFileName(input) {
            const fileName = input.files[0]?.name || '';
            const span = document.getElementById(`file-name-${input.id.split('[')[1].split(']')[0]}`);
            span.textContent = fileName;
        }
    </script>
@endsection
--}}





@extends('admin.layouts.admin')

@section('content')
    <div class="card mt-4">
        <div class="card-header card-header-bg text-white">
            <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.banners.edit_banner') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
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

                <!-- Banner Type Select -->
                <div class="form-group">
                    <label for="type">{{ __('cms.banners.banner_type') }}</label>
                    <select name="type" class="form-control" required>
                        <option value="promotion" {{ $banner->type == 'promotion' ? 'selected' : '' }}>{{ __('cms.banners.promotion') }}</option>
                        <option value="sale" {{ $banner->type == 'sale' ? 'selected' : '' }}>{{ __('cms.banners.sale') }}</option>
                        <option value="seasonal" {{ $banner->type == 'seasonal' ? 'selected' : '' }}>{{ __('cms.banners.seasonal') }}</option>
                        <option value="featured" {{ $banner->type == 'featured' ? 'selected' : '' }}>{{ __('cms.banners.featured') }}</option>
                        <option value="announcement" {{ $banner->type == 'announcement' ? 'selected' : '' }}>{{ __('cms.banners.announcement') }}</option>
                    </select>
                </div>

                <!-- Language Sections -->
                <div id="languages-container">
                    @if(!empty($languages) && count($languages) > 0)
                        <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                            @foreach($languages as $index => $language)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                            id="{{ $language->name }}-tab" 
                                            data-bs-toggle="tab" 
                                            data-bs-target="#{{ $language->name }}" 
                                            type="button" role="tab">
                                        {{ ucwords($language->name) }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mt-3" id="languageTabContent">
                            @foreach($languages as $index => $language)
                                @php
                                    $bannerTranslation = $translations[$language->code] ?? new stdClass();
                                @endphp
                                <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" 
                                     id="{{ $language->name }}" role="tabpanel">
                                    <div class="form-group">
                                        <label for="languages[{{ $index }}][title]">{{ __('cms.banners.title') }}</label>
                                        <input type="text" name="languages[{{ $index }}][title]" 
                                               class="form-control @error('languages.' . $index . '.title') is-invalid @enderror"
                                               value="{{ old('languages.' . $index . '.title', $bannerTranslation->title ?? '') }}" required>
                                        @error('languages.' . $index . '.title') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                    
                                    <!-- Description Field -->
                                    <div class="form-group">
                                        <label for="languages[{{ $index }}][description]">Description</label>
                                        <textarea name="languages[{{ $index }}][description]" 
                                                  class="form-control @error('languages.' . $index . '.description') is-invalid @enderror"
                                                  rows="3">{{ old('languages.' . $index . '.description', $bannerTranslation->description ?? '') }}</textarea>
                                        @error('languages.' . $index . '.description') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="languages[{{ $index }}][image_title]">{{ __('cms.banners.image_title') }}</label>
                                        <input type="text" name="languages[{{ $index }}][image_title]" 
                                               class="form-control @error('languages.' . $index . '.image_title') is-invalid @enderror"
                                               value="{{ old('languages.' . $index . '.image_title', $bannerTranslation->title ?? '') }}">
                                        @error('languages.' . $index . '.image_title') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                     
                                    <!-- Image Upload -->
                                    <label class="form-label mt-2">{{ __('cms.banners.image') }}  ({{ $language->code }})</label>
                                    <input type="file" name="languages[{{ $index }}][image]" 
                                           class="form-control @error('languages.' . $index . '.image') is-invalid @enderror" 
                                           onchange="previewImage(this, '{{ $language->code }}')">
                                    @error('languages.' . $index . '.image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Image Preview -->
                                    <div id="image_preview_{{ $language->code }}" class="mt-2" style="display: {{ !empty($bannerTranslation->image) ? 'block' : 'none' }};">
                                        <img id="image_preview_img_{{ $language->code }}" 
                                         src="{{ !empty($bannerTranslation->image) ? asset('storage/' . $bannerTranslation->image) : '#' }}" 
                                           
                                             alt="Image Preview" class="img-thumbnail" style="max-width: 200px;">  
                                    </div>                                   
                               <input type="hidden" name="languages[{{ $index }}][language_code]" value="{{ $language->code }}">                             
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-danger">{{ __('cms.banners.no_languages_available') }}</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">{{ __('cms.banners.save') }}</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-warning mt-3">Back</a>
            </form>
        </div>
    </div>
    <script>
        function previewImage(input, langCode) {
            const file = input.files[0];
            const previewDiv = document.getElementById(`image_preview_${langCode}`);
            const previewImg = document.getElementById(`image_preview_img_${langCode}`);

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewDiv.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.style.display = 'none';
            }
        }
    </script>
@endsection



