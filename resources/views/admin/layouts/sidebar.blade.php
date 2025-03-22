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
                        <li><a class="nav-link {{ Route::currentRouteName() == 'admin.customers.index' ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">List</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#sellerMenu" role="button" aria-expanded="false" aria-controls="sellerMenu">
                    <span><i class="fas fa-user-tie me-2"></i> <span>Sellers</span></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.sellers.create', 'admin.sellers.index']) ? 'show' : '' }}" id="sellerMenu">
                    <ul class="nav flex-column ms-3">
                        <li>
                            <a class="nav-link {{ Route::currentRouteName() == 'admin.sellers.index' ? 'active' : '' }}" href="{{ route('admin.sellers.create') }}">
                                Add New
                            </a>
                            <a class="nav-link {{ Route::currentRouteName() == 'admin.sellers.index' ? 'active' : '' }}" href="{{ route('admin.sellers.index') }}">
                                List
                            </a>
                        </li>
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
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menus.item.index' ? 'active' : '' }}" href="{{ route('admin.menus.item.index') }}">List</a></li>
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
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.social-media-links.create' ? 'active' : '' }}" href="{{ route('admin.social-media-links.create') }}">Add New</a></li>
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