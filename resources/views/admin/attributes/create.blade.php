@extends('admin.layouts.admin')
@section('title', 'Create Attribute')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header card-header-bg text-white">
            <h6>{{ __('cms.attributes.title_create') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attributes.store') }}" method="POST">
                @csrf
                <!-- Attribute Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('cms.attributes.attribute_name') }}</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Dynamic Attribute Values -->
                <div class="mb-3">
                    <label class="form-label">{{ __('cms.attributes.attribute_values') }}</label>
                    <div id="attribute-values-container">
                        @if(old('values'))
                            @foreach(old('values') as $i => $value)
                                <div class="input-group mb-2 value-group">
                                    <input type="text" name="values[]" value="{{ $value }}" class="form-control @error('values.'.$i) is-invalid @enderror" placeholder="Enter value">
                                    <button type="button" class="btn btn-danger remove-value">{{ __('cms.attributes.remove_value') }}</button>
                                    @error('values.'.$i)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        @else
                            <div class="input-group mb-2 value-group">
                                <input type="text" name="values[]" class="form-control" placeholder="Enter value">
                                <button type="button" class="btn btn-danger remove-value">{{ __('cms.attributes.remove_value') }}</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-value" class="btn btn-primary mt-2">{{ __('cms.attributes.add_value') }}</button>
                </div>

                <!-- Translations Section -->
                <div class="mb-3">
                    <label class="form-label">{{ __('cms.attributes.translations') }}</label>
                    <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                        @foreach ($languages as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $language->code }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $language->code }}" type="button">
                                    {{ ucwords($language->name) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3" id="languageTabContent">
                        @foreach ($languages as $language)
                            <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->code }}">
                                <div id="translation-container-{{ $language->code }}">
                                    @if(old("translations.$language->code"))
                                        @foreach(old("translations.$language->code") as $i => $value)
                                            <div class="input-group mb-2 translation-group">
                                                <input type="text" name="translations[{{ $language->code }}][]" value="{{ $value }}" class="form-control @error('translations.'.$language->code.'.'.$i) is-invalid @enderror" placeholder="Enter {{ $language->name }} value">
                                                <button type="button" class="btn btn-danger remove-translation">{{ __('cms.attributes.remove_value') }}</button>
                                                @error('translations.'.$language->code.'.'.$i)
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2 translation-group">
                                            <input type="text" name="translations[{{ $language->code }}][]" class="form-control" placeholder="Enter {{ $language->name }} value">
                                            <button type="button" class="btn btn-danger remove-translation">{{ __('cms.attributes.remove_value') }}</button>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-secondary add-translation mt-2" data-lang="{{ $language->code }}">
                                    {{ __('cms.attributes.add_value_translation') }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success mt-3">{{ __('cms.attributes.save_attribute') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    @if ($errors->any())
        var firstErrorElement = document.querySelector('.is-invalid');
        if (firstErrorElement) {
            var tabPane = firstErrorElement.closest('.tab-pane');
            if (tabPane) {
                var tabId = tabPane.getAttribute('id');
                var triggerEl = document.querySelector(`button[data-bs-target="#${tabId}"]`);
                if (triggerEl) {
                    var tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                }
            }
        }
    @endif
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Translation string for remove button
    let removeText = "{{ __('cms.attributes.remove_value') }}";

    // Get all languages and names
    let languages = @json($languages->pluck('code')->toArray());
    let languageNames = @json($languages->pluck('name')->toArray());

    // Add value field and corresponding translations
    document.getElementById("add-value").addEventListener("click", function () {
        // Main value input
        let container = document.getElementById("attribute-values-container");
        let newValueGroup = document.createElement("div");
        newValueGroup.classList.add("input-group", "mb-2", "value-group");

        let valueInput = document.createElement("input");
        valueInput.type = "text";
        valueInput.name = "values[]";
        valueInput.classList.add("form-control");
        valueInput.placeholder = "Enter value";

        let removeValueBtn = document.createElement("button");
        removeValueBtn.type = "button";
        removeValueBtn.classList.add("btn", "btn-danger", "remove-value");
        removeValueBtn.textContent = removeText;

        newValueGroup.appendChild(valueInput);
        newValueGroup.appendChild(removeValueBtn);
        container.appendChild(newValueGroup);

        // Add translation fields for all languages
        languages.forEach((lang, index) => {
            let containerLang = document.getElementById("translation-container-" + lang);
            let newTranslationGroup = document.createElement("div");
            newTranslationGroup.classList.add("input-group", "mb-2", "translation-group");

            let input = document.createElement("input");
            input.type = "text";
            input.name = `translations[${lang}][]`;
            input.classList.add("form-control");
            input.placeholder = "Enter " + languageNames[index] + " value";

            let removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.classList.add("btn", "btn-danger", "remove-translation");
            removeBtn.textContent = removeText;

            newTranslationGroup.appendChild(input);
            newTranslationGroup.appendChild(removeBtn);
            containerLang.appendChild(newTranslationGroup);
        });
    });

    // Remove value and corresponding translations
    document.addEventListener("click", function(e) {
        if(e.target && e.target.classList.contains("remove-value")){
            let valueGroup = e.target.closest(".value-group");
            let index = Array.from(document.querySelectorAll("#attribute-values-container .value-group")).indexOf(valueGroup);

            if(valueGroup) valueGroup.remove();

            languages.forEach(lang => {
                let translations = document.querySelectorAll("#translation-container-" + lang + " .translation-group");
                if(translations[index]) translations[index].remove();
            });
        }

        if(e.target && e.target.classList.contains("remove-translation")){
            e.target.closest(".translation-group").remove();
        }
    });

    // Add translation manually per language
    document.querySelectorAll(".add-translation").forEach(button => {
        button.addEventListener("click", function () {
            let lang = this.dataset.lang;
            let index = languages.indexOf(lang);
            let container = document.getElementById("translation-container-" + lang);

            let newGroup = document.createElement("div");
            newGroup.classList.add("input-group", "mb-2", "translation-group");

            let input = document.createElement("input");
            input.type = "text";
            input.name = `translations[${lang}][]`;
            input.classList.add("form-control");
            input.placeholder = "Enter " + languageNames[index] + " value";

            let removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.classList.add("btn", "btn-danger", "remove-translation");
            removeBtn.textContent = removeText;

            newGroup.appendChild(input);
            newGroup.appendChild(removeBtn);
            container.appendChild(newGroup);
        });
    });
});
</script>
@endsection
