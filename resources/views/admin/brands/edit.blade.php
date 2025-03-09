
{{--
@extends('admin.layouts.admin')

@section('content')
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.brands.heading') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Method spoofing for PUT request -->

                <!-- Validation Errors -->
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
                    @foreach($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="translations[{{ $language->code }}][name]">{{ $language->name }}{{ __('cms.brands.name') }}</label>
                                <input type="text" 
                                       name="translations[{{ $language->code }}][name]" 
                                       class="form-control" 
                                       value="{{ old('translations.' . $language->code . '.name', $brand->translations->where('locale', $language->code)->first()->name ?? '') }}" 
                                       required>
                                @error('translations.' . $language->code . '.name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="translations[{{ $language->code }}][description]">{{ $language->name }} {{ __('cms.brands.description') }}</label>
                                <textarea name="translations[{{ $language->code }}][description]" 
                                          class="form-control">{{ old('translations.' . $language->code . '.description', $brand->translations->where('locale', $language->code)->first()->description ?? '') }}</textarea>
                                @error('translations.' . $language->code . '.description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <!-- Logo Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo_url">{{ __('cms.brands.logo') }}</label>
                            <div class="custom-file">
                                <!-- Custom file input with translated "Choose file" text -->
                                <label class="btn btn-primary" for="logo_file">{{ __('cms.brands.choose_file') }}</label>
                                <input type="file" name="logo_url" accept="image/*" class="form-control d-none" id="logo_file">
                            </div>

                            @if($brand->logo_url)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $brand->logo_url) }}" alt="Current Logo" class="img-thumbnail" width="100">
                                </div>
                            @endif

                            <div class="mt-2" id="logo_preview" style="display:none;">
                                <img id="logo_preview_img" src="" alt="Selected Logo" class="img-thumbnail" width="100">
                            </div>
                            @error('logo_url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <button type="submit" class="mt-3 btn btn-primary">{{ __('cms.brands.update') }}</button>
            </form>
        </div>
    </div>

    <script>
        // Handle logo file change event for image preview
        document.getElementById('logo_file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const logoUrl = e.target.result;
                    document.getElementById('logo_preview').style.display = 'block';
                    document.getElementById('logo_preview_img').src = logoUrl;
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
            <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.brands.heading') }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ isset($brand) ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($brand)) 
                    @method('PUT') 
                @endif
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
                                    <label class="form-label">{{ __('cms.brands.name') }} ({{ $language->code }})</label>
                                    <input type="text" name="translations[{{ $language->code }}][name]" 
                                           class="form-control" 
                                           value="{{ old('translations.'.$language->code.'.name', $brand->translations->firstWhere('locale', $language->code)->name ?? '') }}">
                                    
                                    <label class="form-label">{{ __('cms.brands.description') }} ({{ $language->code }})</label>
                                    <textarea name="translations[{{ $language->code }}][description]" 
                                              class="form-control ck-editor-multi-languages">{{ old('translations.'.$language->code.'.description', $brand->translations->firstWhere('locale', $language->code)->description ?? '') }}</textarea>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo_url">{{ __('cms.brands.logo') }}</label>
                                <div class="custom-file">
                                    <label class="btn btn-primary" for="logo_file">{{ __('cms.brands.choose_file') }}</label>
                                    <input type="file" name="logo_url" accept="image/*" class="form-control d-none" id="logo_file">
                                </div>
                                @if(isset($brand) && $brand->logo_url)
                                    <div class="mt-2" id="logo_preview">
                                        <img id="logo_preview_img" src="{{ asset($brand->logo_url) }}" alt="Logo" class="img-thumbnail" width="100">
                                    </div>
                                @endif
                                @error('logo_url')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                </div>
                <button type="submit" class="mt-3 btn btn-primary">
                    {{ isset($brand) ? __('cms.brands.update') : __('cms.brands.create') }}
                </button>
            </form>
        </div>
    </div>
@endsection
@section('js')
<script>
    document.getElementById('logo_file').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var previewElement = document.getElementById('logo_preview');
        var previewImage = document.getElementById('logo_preview_img');

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
    document.querySelectorAll('.ck-editor-multi-languages').forEach((element) => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endsection
