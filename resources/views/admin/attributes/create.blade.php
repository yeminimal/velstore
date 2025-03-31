@extends('admin.layouts.admin')

@section('title', 'Create Attribute')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header card-header-bg text-white">
                <h6>Create Attribute</h6>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div id="errorBar" class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.attributes.store') }}" method="POST">
                    @csrf

                    <!-- Attribute Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Attribute Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dynamic Attribute Values -->
                    <div class="mb-3">
                        <label class="form-label">Attribute Values</label>
                        <div id="attribute-values-container">
                            <div class="input-group mb-2">
                                <input type="text" name="values[]" class="form-control" placeholder="Enter value">
                                <button type="button" class="btn btn-danger remove-value">Remove</button>
                            </div>
                        </div>
                        <button type="button" id="add-value" class="btn btn-primary mt-2">Add Value</button>
                    </div>

                    <!-- Translations Section -->
                    <div class="mb-3">
                        <label class="form-label">Translations</label>
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
                                    <label class="form-label">Translated Value ({{ $language->name }})</label>
                                    <input type="text" name="translations[{{ $language->code }}]" class="form-control">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success mt-3">Save Attribute</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("add-value").addEventListener("click", function() {
                let container = document.getElementById("attribute-values-container");
                let newInputGroup = document.createElement("div");
                newInputGroup.classList.add("input-group", "mb-2");

                let input = document.createElement("input");
                input.type = "text";
                input.name = "values[]";
                input.classList.add("form-control");
                input.placeholder = "Enter value";

                let removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.classList.add("btn", "btn-danger", "remove-value");
                removeBtn.textContent = "Remove";
                removeBtn.addEventListener("click", function() {
                    newInputGroup.remove();
                });

                newInputGroup.appendChild(input);
                newInputGroup.appendChild(removeBtn);
                container.appendChild(newInputGroup);
            });

            document.querySelectorAll(".remove-value").forEach(button => {
                button.addEventListener("click", function() {
                    this.parentElement.remove();
                });
            });
        });
    </script>
@endsection
