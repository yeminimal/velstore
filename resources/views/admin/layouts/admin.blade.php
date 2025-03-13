<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">    
    @yield('css')
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar" class="d-flex flex-column p-3">
        <div class="logo-container">
            <img src="https://via.placeholder.com/100" alt="Logo">
        </div>
        <div class="search-container position-relative">
            <input type="text" class="form-control" placeholder="Search..." id="searchInput" autocomplete="off">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" href="#"><i class="fas fa-home me-2"></i> <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#categoryMenu" role="button" aria-expanded="false" aria-controls="categoryMenu">
                    <span><i class="fas fa-th-large me-2"></i> <span>Categories</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.categories.create' || Route::currentRouteName() == 'admin.categories.index' ? 'show' : '' }}" id="categoryMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.categories.create' ? 'active' : '' }}" href="{{ route('admin.categories.create') }}">Add New</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.categories.index' ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">List</a></li>
                    </ul>
                </div>
            </li>           
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#brandMenu" role="button" aria-expanded="false" aria-controls="brandMenu">
                    <span><i class="fas fa-tags me-2"></i> <span>Brands</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.brands.create' || Route::currentRouteName() == 'admin.brands.index' ? 'show' : '' }}" id="brandMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.brands.create' ? 'active' : '' }}" href="{{ route('admin.brands.create') }}">Add New</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.brands.index' ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">List</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#productMenu" role="button" aria-expanded="false" aria-controls="productMenu">
                    <span><i class="fas fa-box me-2"></i> <span>Products</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.products.create' || Route::currentRouteName() == 'admin.products.index' ? 'show' : '' }}" id="productMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.products.create' ? 'active' : '' }}" href="{{ route('admin.products.create') }}">Add New</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.products.index' ? 'active' : '' }}" href="{{ route('admin.products.index') }}">List</a></li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#customerMenu" role="button" aria-expanded="false" aria-controls="customerMenu">
                        <span><i class="fas fa-users me-2"></i> <span>Customers</span></span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.customers.create', 'admin.customers.index']) ? 'show' : '' }}" id="customerMenu">
                        <ul class="nav flex-column ms-3">
                            <li><a class="nav-link {{ Route::currentRouteName() == 'admin.customers.create' ? 'active' : '' }}" href="{{ route('admin.customers.create') }}">Add New</a></li>
                            <li><a class="nav-link {{ Route::currentRouteName() == 'admin.customers.index' ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">List</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#productReviewMenu" role="button" aria-expanded="false" aria-controls="productReviewMenu">
                        <span><i class="fas fa-star me-2"></i> <span>Product Reviews</span></span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.product_reviews.create', 'admin.product_reviews.index']) ? 'show' : '' }}" id="productReviewMenu">
                        <ul class="nav flex-column ms-3">
                            <li><a class="nav-link {{ Route::currentRouteName() == 'admin.product_reviews.show' ? 'active' : '' }}" href="">Add New</a></li>
                            <li><a class="nav-link {{ Route::currentRouteName() == 'admin.product_reviews.index' ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">List</a></li>
                        </ul>
                    </div>
                </li>                
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#bannerMenu" role="button" aria-expanded="false" aria-controls="bannerMenu">
                    <span><i class="fas fa-image me-2"></i> <span>Banners</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.banners.create' || Route::currentRouteName() == 'admin.banners.index' ? 'show' : '' }}" id="bannerMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.banners.create' ? 'active' : '' }}" href="{{ route('admin.banners.create') }}">Add New</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.banners.index' ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">List</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuMenu" role="button" aria-expanded="false" aria-controls="menuMenu">
                    <span><i class="fas fa-bars me-2"></i> <span>Menu</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.menus.create' || Route::currentRouteName() == 'admin.menus.index' ? 'show' : '' }}" id="menuMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menus.create' ? 'active' : '' }}" href="{{ route('admin.menus.create') }}">Add New</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menus.index' ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">List</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuItemMenu" role="button" aria-expanded="false" aria-controls="menuItemMenu">
                    <span><i class="fas fa-list me-2"></i> <span>Menu Items</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.menuitems.create' || Route::currentRouteName() == 'admin.menuitems.index' ? 'show' : '' }}" id="menuItemMenu">
                    <ul class="nav flex-column ms-3">
                        @if(isset($menu) && $menu)
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menu.items.create' ? 'active' : '' }}" href="{{ route('admin.menus.items.create', $menu) }}">Add New</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menu.items.index' ? 'active' : '' }}" href="{{ route('admin.menus.items.index', $menu) }}">List</a></li>
                        @endif
                    </ul>
                </div>
            </li>                       
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#socialMediaLinkMenu" role="button" aria-expanded="false" aria-controls="socialMediaLinkMenu">
                    <span><i class="fas fa-link me-2"></i> <span>Social Media Links</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.social-media-links.create' || Route::currentRouteName() == 'admin.social-media-links.index' ? 'show' : '' }}" id="socialMediaLinkMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.social-media-links.create' ? 'active' : '' }}" href="{{ route('admin.social-media-links.store') }}">Add New</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.social-media-links.index' ? 'active' : '' }}" href="{{ route('admin.social-media-links.index') }}">List</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#siteSettingsMenu" role="button" aria-expanded="false" aria-controls="siteSettingsMenu">
                    <span><i class="fas fa-cog me-2"></i> <span>Site Settings</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'site-settings.index' ? 'show' : '' }}" id="siteSettingsMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a class="nav-link {{ Route::currentRouteName() == 'site-settings.index' ? 'active' : '' }}" href="{{ route('site-settings.index') }}">Manage Settings</a></li>
                    </ul>
                </div>
            </li>           
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#ordersMenu" role="button" aria-expanded="false" aria-controls="ordersMenu">
                    <span><i class="fas fa-shopping-cart me-2"></i> <span>Orders</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.orders.index' || Route::currentRouteName() == 'admin.orders.pending' || Route::currentRouteName() == 'admin.orders.completed' ? 'show' : '' }}" id="ordersMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.orders.index' ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">All Orders</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.orders.pending' ? 'active' : '' }}" href="">Pending Orders</a></li>
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.orders.completed' ? 'active' : '' }}" href="">Completed Orders</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
    
    <!-- Content Area -->
    <div id="content" class="w-100">
        <nav class="navbar navbar-expand navbar-light bg-light p-3">
            <button class="btn btn-dark" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <!-- Language Change Dropdown -->
            <div class="dropdown ms-auto me-3">
                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="https://flagcdn.com/w40/us.png" width="20"> English
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item language-select {{ app()->getLocale() == 'en' ? 'active' : '' }}" data-lang="en" href="#"><img src="https://flagcdn.com/w40/us.png" width="20"> English</a></li>
                    <li><a class="dropdown-item language-select " data-lang="es" href="#"><img src="https://flagcdn.com/w40/es.png" width="20"> Spanish</a></li>
                    <li><a class="dropdown-item language-select" data-lang="fr" href="#"><img src="https://flagcdn.com/w40/fr.png" width="20"> French</a></li>
                    <li><a class="dropdown-item language-select" data-lang="ar" href="#"><img src="https://flagcdn.com/w40/sa.png" width="20"> Arabic</a></li>
                    <li><a class="dropdown-item language-select" data-lang="de" href="#"><img src="https://flagcdn.com/w40/de.png" width="20"> German</a></li>
                    <li><a class="dropdown-item language-select" data-lang="fa" href="#"><img src="https://flagcdn.com/w40/ir.png" width="20"> Persian (Farsi)</a></li>
                    <li><a class="dropdown-item language-select" data-lang="hi" href="#"><img src="https://flagcdn.com/w40/in.png" width="20"> Hindi</a></li>
                    <li><a class="dropdown-item language-select" data-lang="id" href="#"><img src="https://flagcdn.com/w40/id.png" width="20"> Indonesian</a></li>
                    <li><a class="dropdown-item language-select" data-lang="it" href="#"><img src="https://flagcdn.com/w40/it.png" width="20"> Italian</a></li>
                    <li><a class="dropdown-item language-select" data-lang="ja" href="#"><img src="https://flagcdn.com/w40/jp.png" width="20"> Japanese</a></li>
                    <li><a class="dropdown-item language-select" data-lang="ko" href="#"><img src="https://flagcdn.com/w40/kr.png" width="20"> Korean</a></li>
                    <li><a class="dropdown-item language-select" data-lang="nl" href="#"><img src="https://flagcdn.com/w40/nl.png" width="20"> Dutch</a></li>
                    <li><a class="dropdown-item language-select" data-lang="pl" href="#"><img src="https://flagcdn.com/w40/pl.png" width="20"> Polish</a></li>
                    <li><a class="dropdown-item language-select" data-lang="pt" href="#"><img src="https://flagcdn.com/w40/pt.png" width="20"> Portuguese</a></li>
                    <li><a class="dropdown-item language-select" data-lang="ru" href="#"><img src="https://flagcdn.com/w40/ru.png" width="20"> Russian</a></li>
                    <li><a class="dropdown-item language-select" data-lang="th" href="#"><img src="https://flagcdn.com/w40/th.png" width="20"> Thai</a></li>
                    <li><a class="dropdown-item language-select" data-lang="tr" href="#"><img src="https://flagcdn.com/w40/tr.png" width="20"> Turkish</a></li>
                    <li><a class="dropdown-item language-select" data-lang="vi" href="#"><img src="https://flagcdn.com/w40/vn.png" width="20"> Vietnamese</a></li>
                    <li><a class="dropdown-item language-select" data-lang="zh" href="#"><img src="https://flagcdn.com/w40/cn.png" width="20"> Chinese</a></li>                    
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="https://via.placeholder.com/40" class="rounded-circle" alt="Profile">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <!-- Modal for Confirmation -->
    <div class="modal fade" id="languageChangeModal" tabindex="-1" aria-labelledby="languageChangeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="languageChangeModalLabel">Change Language</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to change the language?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmChange" class="btn btn-primary">Yes, Change</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            const menuItems = document.querySelectorAll(".nav-item");
            searchInput.addEventListener("input", function () {
                const searchTerm = searchInput.value.toLowerCase();
                menuItems.forEach((item) => {
                    let linkTexts = item.querySelectorAll(".nav-link");
                    let matchFound = false;

                    linkTexts.forEach((link) => {
                        if (link.textContent.toLowerCase().includes(searchTerm)) {
                            matchFound = true;
                            link.closest(".nav-item").style.display = "block"; // Show matching items
                        } else {
                            link.closest(".nav-item").style.display = "none"; // Hide non-matching items
                        }
                    });

                    // If it's a parent menu and any child matches, show parent
                    let submenu = item.querySelector(".collapse");
                    if (submenu) {
                        let childLinks = submenu.querySelectorAll(".nav-link");
                        childLinks.forEach((childLink) => {
                            if (childLink.textContent.toLowerCase().includes(searchTerm)) {
                                matchFound = true;
                            }
                        });

                        if (matchFound) {
                            item.style.display = "block";
                            submenu.classList.add("show"); // Expand if match found
                        } else {
                            item.style.display = "none";
                            submenu.classList.remove("show"); // Collapse if no match
                        }
                    }
                });
            });
        });
    </script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @yield('js')
</body>
</html>