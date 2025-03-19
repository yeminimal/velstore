<header class="">
    <div class="top-bar d-none d-md-block">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-md-4">
                    <div class="numbers-top d-inline-flex">
                        <a href="tel:0123 456 789"><img src="assets/images/phone-top.png" alt=""> Call Now:
                            <strong>0123 456 789</strong></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="top-links">
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Store Locator</a></li>
                        <li><a href="#">Free Shipping</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('change.currency') }}" method="POST">
                        @csrf
                        <select name="currency_code" onchange="this.form.submit()">
                            @foreach (\App\Models\Currency::all() as $currency)
                                <option value="{{ $currency->code }}" {{ session('currency', 'USD') == $currency->code ? 'selected' : '' }}>
                                    {{ $currency->name }} ({{ $currency->symbol }})
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <div class="social-top d-flex justify-content-end">
                        {{ __('xylo.header.social_media') }}
                        <a href="facebook.com"><i class="fa-brands fa-square-facebook"></i></a>
                        <a href="twitter.com"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="instagram.com"><i class="fa-brands fa-instagram"></i></a>
                        <a href="linkedin.com"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <nav class="navbar d-block d-md-none pb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="assets/images/logo-main.png" alt="" style="width: 200px;"></a>
                <!-- Button that triggers the offcanvas -->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#fullScreenNav" aria-controls="fullScreenNav" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="d-md-flex justify-content-between align-items-center pt-4 pb-4 d-none">
            <a href="#" class="logo"><img src="assets/images/logo-main.png" alt=""></a>
            <div class="header-categories">
                <div class="input-group">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">All Categories</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Separated link</a></li>
                    </ul>
                    <form class="d-flex">
                        <input type="text" class="form-control" placeholder="Search your product...">
                        <button><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="maccount">
                <a href="#"><i class="fa fa-user"></i> My Account</a>
            </div>
        </div>

        <div class="navigation d-md-flex justify-content-between d-none">
            <nav>
                @if ($headerMenu)
                    <ul>
                        @foreach ($headerMenu->menuItems as $menuItem)
                            <li>
                                <a href="{{ url($menuItem->slug) }}">
                                    {{ $menuItem->translation->title ?? 'No Translation' }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </nav>
            <button class="cat-item">
                Cart Item <img src="assets/images/cart-icon.png" alt="">
                <span class="count">0</span>
            </button>
        </div>

        <div class="offcanvas offcanvas-top bg-dark text-white" tabindex="-1" id="fullScreenNav" aria-labelledby="fullScreenNavLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title mt-4" id="fullScreenNavLabel"><img src="assets/images/footer-logo.png" alt=""></h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-center align-items-center">
              <ul class="navbar-nav text-center">
                <li class="nav-item">
                  <a class="nav-link text-white fs-5" href="#">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white fs-5" href="#">Features</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white fs-5" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white fs-5" href="#">Blog</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white fs-5" href="#">Contact</a>
                </li>
              </ul>
            </div>
          </div>
    </div>
</header>