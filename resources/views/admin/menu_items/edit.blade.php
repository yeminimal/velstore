
{{--

@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <!-- Card-like Heading for "Edit Menu Item" -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.menu_items.edit') }}</h6>
        </div>
    </div>

    <!-- Menu Item Form (similar to category form) -->
    <div class="card mt-4">
        <div class="card-body">
            @if(session('error'))
                <div id="errorBar" class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif

            <!-- Form for editing Menu Item -->
            <form action="{{ route('admin.menu.items.update', ['menuId' => $menu->id, 'menuItemId' => $menuItem->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Menu Dropdown -->
                <div class="mb-3">
                    <label for="menu" class="form-label">{{ __('cms.menu_items.select_menu') }}</label>
                    <select class="form-select @error('menu') is-invalid @enderror" id="menu" name="menu" required>
                        <option value="" disabled selected>{{ __('cms.menu_items.select_menu') }}</option>
                        
                        <!-- Loop through the menus collection -->
                        @foreach($menus as $menuOption)
                            <option value="{{ $menuOption->id }}" 
                                @if($menuOption->id == old('menu', $menu->id)) selected @endif>
                                {{ $menuOption->title }} <!-- Display the title of each menu -->
                            </option>
                        @endforeach
                    </select>
                    @error('menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Order Number -->
                <div class="border p-3 mb-3 rounded-3">
                    <div class="mb-3">
                        <label for="order_number" class="form-label">{{ __('cms.menu_items.order_number') }}</label>
                        <input type="number" 
                               name="order_number" 
                               id="order_number" 
                               class="form-control @error('order_number') is-invalid @enderror" 
                               value="{{ old('order_number', $menuItem->order_number) }}" 
                               required>
                        @error('order_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parent Item -->
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">{{ __('cms.menu_items.parent_item') }}</label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">None</option>
                            @foreach($menu->menuItems as $item)
                                <option value="{{ $item->id }}" 
                                    @if($item->id == old('parent_id', $menuItem->parent_id)) selected @endif>
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
                                   value="{{ old('title_' . $language->code, $menuItem->translations->firstWhere('language_code', $language->code)->title ?? '') }}"
                                   required>
                            @error('title_' . $language->code)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success">{{ __('cms.menu_items.update_button') }}</button>
            </form>
        </div>
    </div>

</div>
@endsection
--}}


@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <!-- Card-like Heading for "Edit Menu Item" -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.menu_items.edit') }}</h6>
        </div>
    </div>

    <!-- Menu Item Form -->
    <div class="card mt-4">
        <div class="card-body">
            @if(session('error'))
                <div id="errorBar" class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif

            <!-- Form for editing Menu Item -->
            <form action="{{ route('admin.menu.items.update', ['menuId' => $menu->id, 'menuItemId' => $menuItem->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Menu Dropdown -->
                <div class="mb-3">
                    <label for="menu" class="form-label">{{ __('cms.menu_items.select_menu') }}</label>
                    <select class="form-select @error('menu') is-invalid @enderror" id="menu" name="menu" required>
                        <option value="" disabled selected>{{ __('cms.menu_items.select_menu') }}</option>
                        @foreach($menus as $menuOption)
                            <option value="{{ $menuOption->id }}" @if($menuOption->id == old('menu', $menu->id)) selected @endif>
                                {{ $menuOption->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Order Number -->
                <div class="mb-3">
                    <label for="order_number" class="form-label">{{ __('cms.menu_items.order_number') }}</label>
                    <input type="number" name="order_number" id="order_number" class="form-control @error('order_number') is-invalid @enderror" value="{{ old('order_number', $menuItem->order_number) }}" required>
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
                            <option value="{{ $item->id }}" @if($item->id == old('parent_id', $menuItem->parent_id)) selected @endif>
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
                            <input type="text" name="title_{{ $language->code }}" class="form-control @error('title_' . $language->code) is-invalid @enderror" value="{{ old('title_' . $language->code, $menuItem->translations->firstWhere('language_code', $language->code)->title ?? '') }}" required>
                            @error('title_' . $language->code)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <button type="submit" class="mt-3 btn btn-success">{{ __('cms.menu_items.update_button') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
