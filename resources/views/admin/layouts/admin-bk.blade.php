<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


    <style>
        /* Custom Colors */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
        }
        .sidebar {
            background-color: #ffffff;
            color: #333333;
            height: 100vh;
            padding-top: 20px;
            padding-left: 15px;
            padding-right: 15px;
            width: 260px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar h3 {
            color: #333333;
            font-size: 1.5rem;
            margin-bottom: 30px;
        }
        .sidebar .nav-link {
            color: #333333;
            border-bottom: 1px solid #f4f7f6;
            padding: 10px 15px;
        }
        .sidebar .nav-link:hover {
            background-color: #66b3ff;
            color: #ffffff;
        }
        .topbar {
            background-color: #ffffff;
            color: #333333;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .topbar .dropdown-menu {
            background-color: #ffffff;
            border: none;
        }
        .topbar .dropdown-item:hover {
            background-color: #66b3ff;
            color: white;
        }
        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .dt-heading{
            font-size: 1.1rem;
        }
        .dt-trash{
            padding: 4px 10px  !important;
            cursor: pointer;
        }
    </style>
    

    @yield('css')

    <style>
        /* Table style */
        table.dataTable {
          width: 100%;
          background-color: #fff; /* White background for the table */
        }
    
        /* Header style */
        table.dataTable thead tr th {
          background-color: #f4f7f6 !important; /* Heading background color */
        }
    
        /* Heading text color */
        table.dataTable thead th {
          color: #333333; /* Heading text color */
          font-weight: bold; /* Optional: make headings bold */
        }
    
        /* Remove borders around table and cells */
        table.dataTable td,
        table.dataTable th {
          border: none !important; /* Remove all borders */
        }
    
        /* Hover effect for rows */
        table.dataTable tbody tr:hover{
          background-color: #f4f7f6 !important;
          cursor: pointer;
        }
        
        /* Optional: Adjust padding inside cells */
        table.dataTable td,
        table.dataTable th {
          padding: 1rem; /* Adjust the padding if needed */
        }


    .dataTables_filter input {
      border-radius: 0.5rem !important; /* Make the input field rounded */
      margin-bottom: 1rem; /* Add margin below the input */
      padding: 0.5rem 1rem; /* Add padding for better spacing */
      width: auto;
    }

    .dataTables_filter input::placeholder {
      color: #333333; /* Set a color for the placeholder text */
      font-style: italic; /* Optional: make the placeholder italic */
    }

    .table > :not(caption) > * > * {
        background-color: transparent !important;
    }

    /* DataTables Pagination Styling - Bootstrap 5 Style */

/* Pagination container */
.dataTables_paginate {
    margin-top: 20px;
    text-align: center;
}

/* Pagination button */
.dataTables_paginate .paginate_button {
    border-radius: 0.375rem; /* Rounded corners */
    padding: 0.375rem 0.75rem;
    margin: 0 0.125rem;
    color: #007bff;
    background-color: #ffffff;
    border: 1px solid #ccc;
    font-size: 14px;
    font-weight: 500;
}

/* Hover effect for pagination buttons */
.dataTables_paginate .paginate_button:hover {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

/* Active pagination button (current page) */
.dataTables_paginate .paginate_button.current {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

/* Disabled pagination buttons */
.dataTables_paginate .paginate_button:disabled {
    color: #ccc;
    background-color: #f8f9fa;
    border-color: #ddd;
}

/* Focus effect (optional) */
.dataTables_paginate .paginate_button:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5); /* Bootstrap focus color */
}

/* Previous and Next buttons */
.dataTables_paginate .paginate_button.previous,
.dataTables_paginate .paginate_button.next {
    font-size: 16px; /* Optional: make previous/next buttons larger */
}

/* Pagination info text */
.dataTables_info {
    font-size: 14px;
    color: #6c757d;
}


/* Style for the toggle switch */
/* Style for the smaller toggle switch */
/* Style for the even smaller toggle switch */
.switch {
  position: relative;
  display: inline-block;
  width: 30px;  /* Further reduced width */
  height: 16px; /* Further reduced height */
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 50px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 12px;  /* Further reduced height */
  width: 12px;   /* Further reduced width */
  border-radius: 50px;
  left: 2px;     /* Adjusted to fit within the smaller toggle */
  bottom: 2px;   /* Adjusted to fit within the smaller toggle */
  background-color: white;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #4CAF50;
}

input:checked + .slider:before {
  transform: translateX(14px);  /* Adjusted for smaller size */
}


</style>
</head>
<body>
    <!-- Sidebar and Content Wrapper -->
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-light p-3" id="sidebar">
            <h3>Admin Panel</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.categories.index') }}"><i class="bi bi-list-ul"></i> Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.products.index') }}"><i class="bi bi-box-fill"></i> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.product_variants.index') }}"><i class="bi bi-box-fill"></i>Product Variants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#brandsSubmenu"><i class="bi bi-tag-fill"></i> Brands</a>
                    <!-- Child items (Sub-menu) -->
                    <ul class="nav flex-column ms-3 collapse" id="brandsSubmenu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.brands.create') }}">
                                <i class="bi bi-plus-circle-fill"></i> {{ __('cms.brands.add_new') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.brands.index') }}">
                                <i class="bi bi-list-ul"></i> View Brands
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.banners.index') }}"><i class="bi bi-image-fill"></i> Banners</a>    
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#socialMediaLinksSubmenu"><i class="bi bi-menu-button-wide-fill"></i> Menus</a>
                    <!-- Child items (Sub-menu) -->
                    <ul class="nav flex-column ms-3 collapse" id="socialMediaLinksSubmenu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.menus.index') }}">
                                <i class="bi bi-plus-circle-fill"></i> Menu
                            </a>
                        </li>
                        <li class="nav-item">
                            @if(isset($menu) && $menu !== null)
                            <a class="nav-link" href="{{ route('admin.menu.items.index', $menu->id) }}">
                                <i class="bi bi-pencil-square-fill"></i> Menu Item
                            </a>
                            @else
                            <a class="nav-link" href="#">
                                <i class="bi bi-pencil-square-fill"></i> Menu Item (Menu not found)
                            </a>
                            @endif
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('site-settings.index')}}"><i class="bi bi-gear-fill"></i> Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.orders.index')}}"><i class="bi bi-box-arrow-in-right"></i> Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.social-media-links.index')}}"><i class="bi bi-facebook"></i> Social Media Links</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" href="{{ route('site-settings.index') }}">
                        <span><i class="fas fa-cog me-2"></i> <span>Site Settings</span></span>
                    </a>
                </li>
                
        
            </ul>            
        </div>

        <!-- Main Content -->
        <div class="flex-fill">
            <!-- Top Bar -->
            <div class="topbar d-flex justify-content-between bg-white p-3 shadow-sm">
                <div class="d-flex align-items-center">
                    <button class="btn text-dark" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="ms-3 mb-0">@yield('page-title', 'Dashboard')</h4>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn text-dark dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://via.placeholder.com/40" alt="Profile" class="profile-image rounded-circle">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#">{{ cms_translate('profile.profile') }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ cms_translate('profile.setting') }}</a></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ cms_translate('profile.logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="container mt-4">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @yield('js')
</body>
</html>