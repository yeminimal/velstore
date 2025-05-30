@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6>Create Page</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <ul class="nav nav-tabs" role="tablist">
                @foreach($activeLanguages as $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                data-bs-toggle="tab" 
                                data-bs-target="#lang-{{ $language->code }}" 
                                type="button">
                            {{ ucwords($language->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content mt-3">
                @foreach($activeLanguages as $language)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $language->code }}">
                        <div class="mb-3">
                            <label class="form-label">Title ({{ $language->code }})</label>
                            <input type="text" name="translations[{{ $language->code }}][title]" 
                                   class="form-control" value="{{ old("translations.{$language->code}.title") }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content ({{ $language->code }})</label>
                            <textarea name="translations[{{ $language->code }}][content]" 
                                      class="form-control ck-editor-multi-languages">{{ old("translations.{$language->code}.content") }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image ({{ $language->code }})</label>
                            <input type="file" name="translations[{{ $language->code }}][image]" class="form-control">
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.querySelectorAll('.ck-editor-multi-languages').forEach(el => {
        ClassicEditor.create(el).catch(console.error);
    });
</script>
@endsection
