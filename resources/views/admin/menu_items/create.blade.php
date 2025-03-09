{{--

@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <!-- Card-like Heading for "Create Menu Item" -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.menu_items.create') }}</h6>
        </div>
    </div>

    <!-- Menu Item Form (similar to category form) -->
    <div class="card mt-4">
        <div class="card-body">
            @if(session('error'))
                <div id="errorBar" class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif

            <!-- Form for creating Menu Item -->
            <form action="{{ route('admin.menu.items.store', $menu->id) }}" method="POST">
                @csrf

                <div class="border p-3 mb-3 rounded-3">
                    <div class="form-group">
                        <label for="menu">{{ __('cms.menu_items.choose_an_option') }}</label>
                        <select class="form-select" id="menu" name="menu">
                            <option value="" disabled selected>{{ __('cms.menu_items.select_an_option') }}</option>
                            <option value="option1">{{ __('cms.menu_items.option1') }}</option>
                            <option value="option2">{{ __('cms.menu_items.option2') }}</option>
                            <option value="option3">{{ __('cms.menu_items.option3') }}</option>
                            <option value="option4">{{ __('cms.menu_items.option4') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Order Number -->
                <div class="border p-3 mb-3 rounded-3">
                    <div class="mb-3">
                        <label for="order_number" class="form-label">{{ __('cms.menu_items.order_number') }}</label>
                        <input type="number" 
                               name="order_number" 
                               id="order_number" 
                               class="form-control @error('order_number') is-invalid @enderror" 
                               required>
                        @error('order_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parent Item -->
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">{{ __('cms.menu_items.parent_item') }}</label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">{{ __('cms.menu_items.parent_none') }}</option>
                            @foreach($menu->menuItems as $item)
                                <option value="{{ $item->id }}">
                                    @php
                                        $translation = $item->translations ? $item->translations->first() : null;
                                    @endphp
                                    {{ $translation->title ?? 'No Title' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dynamic Title Fields for Each Language -->
                    @foreach ($languages as $language)
                        <div class="mb-3">
                            <label for="title_{{ $language->code }}" class="form-label">
                                {{ __('cms.menu_items.title') }} (in {{ $language->name }})
                            </label>
                            <input type="text" 
                                   name="title_{{ $language->code }}" 
                                   id="title_{{ $language->code }}" 
                                   class="form-control @error('title_' . $language->code) is-invalid @enderror" 
                                   required>
                            @error('title_' . $language->code)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach

                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success">{{ __('cms.menu_items.button') }}</button>
            </form>
        </div>
    </div>

</div>
@endsection

--}}



@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <!-- Card-like Heading for "Create Menu Item" -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.menu_items.create') }}</h6>
        </div>
    </div>

    <!-- Menu Item Form -->
    <div class="card mt-4">
        <div class="card-body">
            @if(session('error'))
                <div id="errorBar" class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif

            <!-- Form for creating Menu Item -->
            <form action="{{ route('admin.menu.items.store', $menu->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="menu" class="form-label">{{ __('cms.menu_items.choose_an_option') }}</label>
                    <select class="form-select" id="menu" name="menu">
                        <option value="" disabled selected>{{ __('cms.menu_items.select_an_option') }}</option>
                        <option value="order_number">{{ __('cms.menu_items.order_number') }}</option>
                        <option value="parent_item">{{ __('cms.menu_items.parent_item') }}</option>
                        <option value="none">{{ __('cms.menu_items.parent_none') }}</option>
                    </select>
                </div>

                <!-- Order Number -->
                <div class="mb-3">
                    <label for="order_number" class="form-label">{{ __('cms.menu_items.order_number') }}</label>
                    <input type="number" name="order_number" id="order_number" class="form-control" required>
                </div>

                <!-- Parent Item -->
                <div class="mb-3">
                    <label for="parent_id" class="form-label">{{ __('cms.menu_items.parent_item') }}</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                        <option value="">{{ __('cms.menu_items.parent_none') }}</option>
                        @foreach($menu->menuItems as $item)
                            <option value="{{ $item->id }}">
                                @php
                                    $translation = $item->translations ? $item->translations->first() : null;
                                @endphp
                                {{ $translation->title ?? 'No Title' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dynamic Title Fields for Each Language -->
                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                    @foreach ($languages as $language)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $language->code }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $language->code }}" type="button" role="tab">{{ ucwords($language->name) }}</button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content mt-3" id="languageTabContent">
                    @foreach ($languages as $language)
                        <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->code }}" role="tabpanel">
                            <label class="form-label">{{ __('cms.menu_items.title') }} ({{ $language->code }})</label>
                            <input type="text" name="title_{{ $language->code }}" class="form-control" required>
                        </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <button type="submit" class="mt-3 btn btn-success">{{ __('cms.menu_items.button') }}</button>
            </form>
        </div>
    </div>

</div>
@endsection
