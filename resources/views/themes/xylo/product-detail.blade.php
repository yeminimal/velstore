@extends('themes.xylo.layouts.master')

@section('content')
    <section class="banner-area inner-banner pt-5 animate__animated animate__fadeIn productinnerbanner">
        <div class="container h-100">
            <div class="row">
                <div class="col-md-4">
                    <div class="breadcrumbs">
                        <a href="#">Home Page</a> <i class="fa fa-angle-right"></i> <a href="#">Headphone</a> <i
                            class="fa fa-angle-right"></i> Espresso decaffeinato
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="main-detail pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 position-relative">
                    <div class="slider-for">
                        <div><img src="assets/images/prodict-detailimg.png" alt=""></div>
                        <div><img src="assets/images/prodict-detailimg.png" alt=""></div>
                        <div><img src="assets/images/prodict-detailimg.png" alt=""></div>

                    </div>


                    <div class="slider-nav imgnav">
                        <div><img src="assets/images/prodict-detailthumb.png" alt=""></div>
                        <div><img src="assets/images/prodict-detailthumb.png" alt=""></div>
                        <div><img src="assets/images/prodict-detailthumb.png" alt=""></div>

                    </div>







                </div>
                <div class="col-md-6 pro-textarea">
                    <div class=" mb-2 mt-3  btnss">
                        IN STOCK
                    </div>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span class="spanstar"> (5 customer reviews)</span>
                    </div>
                    <h1 class="sec-heading">{{ $product->translation->name }}</h1>
                    <h2>{{ $product->price }}</h2>
                    <p>{{ $product->translation->description }}</p>

                    <div class="product-options">
                        <div class="color-options">
                            <h3>Color</h3>
                            <div class="color-wrapper">
                                <input type="radio" name="color" id="color-black" checked>
                                <label for="color-black" class="color-circle black"></label>

                                <input type="radio" name="color" id="color-blue">
                                <label for="color-blue" class="color-circle blue"></label>

                                <input type="radio" name="color" id="color-gray">
                                <label for="color-gray" class="color-circle gray"></label>

                                <input type="radio" name="color" id="color-pink">
                                <label for="color-pink" class="color-circle pink"></label>

                                <input type="radio" name="color" id="color-red">
                                <label for="color-red" class="color-circle red"></label>

                                <input type="radio" name="color" id="color-yellow">
                                <label for="color-yellow" class="color-circle yellow"></label>

                                <input type="radio" name="color" id="color-teal">
                                <label for="color-teal" class="color-circle teal"></label>

                                <input type="radio" name="color" id="color-white">
                                <label for="color-white" class="color-circle white"></label>
                            </div>
                        </div>

                        <div class="size-options mt-3">
                            <h3>Size</h3>
                            <div class="size-wrapper">
                                <input type="radio" name="size" id="size-m">
                                <label for="size-m" class="size-box">M</label>

                                <input type="radio" name="size" id="size-l">
                                <label for="size-l" class="size-box">L</label>

                                <input type="radio" name="size" id="size-xl">
                                <label for="size-xl" class="size-box">XL</label>

                                <input type="radio" name="size" id="size-x">
                                <label for="size-x" class="size-box">X</label>
                            </div>
                        </div>
                    </div>


                    <!-- Quantity Selector and Cart Button -->
                    <div class="cart-actions mt-3 d-flex">
                        <div class="quantity me-4">
                            <button onclick="changeQty(-1)">-</button>
                            <input type="text" id="qty" value="1">
                            <button onclick="changeQty(1)">+</button>
                        </div>
                        <button class="add-to-cart read-more">Add to Cart</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="reviewbox">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Reviews(5)</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>

                    </div>
                </div>
            </div>
            <div class="column">

                <div class="col-md-7"></div>
                <div class="randomt">
                    Diam integer turpis tristique integer cursuws dignissim. Euismod libero pellentesq suspendisseit an
                    amet, consectetur
                    Libero quaerat commodi ab quo. Ut accusamus qui aliquam corrupti. Repellendus modi velit minus nam
                    fugit veniam. Hic qui quis deleniti vero. Ad quis nostrum velit nihil <br>

                    Necessitatibus distinctio esse illum sit ex assumenda. Iusto omnis consequatur modi porro
                    perspiciatis. Qui neque aut quia ipsa sint tenetur non amet.

                    adipiscing elitmperdiet nisvunc imperdras eliton ameoumsa dummy text.
                </div>

            </div>
        </div>
    </div>

    <section class="trending-products animate-on-scroll">
        <div class="container position-relative">
            <h1 class="text-start pb-5 sec-heading">Trending Products</h1>

            <div class="product-slider">
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="product-img">
                        <img src="assets/images/prodict-img1.png" alt="Product">
                        <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                    </div>
                    <div class="product-info mt-4">
                        <div class="top-info">
                            <div class="reviews"><i class="fa-solid fa-star"></i> (11.6k Reviews)</div>
                        </div>
                        <div class="bottom-info">
                            <div class="left">
                                <h3>Product Heading Here</h3>
                                <p class="price">$349 <span class="sold-out">Sold Out 85%</span></p>
                            </div>
                            <button class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></button>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="assets/images/prodict-img1.png" alt="Product">
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info mt-4">
                        <div class="top-info">
                            <div class="reviews"><i class="fa-solid fa-star"></i> (11.6k Reviews)</div>
                        </div>
                        <div class="bottom-info">
                            <div class="left">
                                <h3>Product Heading Here</h3>
                                <p class="price">$349 <span class="sold-out">Sold Out 85%</span></p>
                            </div>
                            <button class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></button>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="assets/images/prodict-img1.png" alt="Product">
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info mt-4">
                        <div class="top-info">
                            <div class="reviews"><i class="fa-solid fa-star"></i> (11.6k Reviews)</div>
                        </div>
                        <div class="bottom-info">
                            <div class="left">
                                <h3>Product Heading Here</h3>
                                <p class="price">$349 <span class="sold-out">Sold Out 85%</span></p>
                            </div>
                            <button class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></button>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="assets/images/prodict-img1.png" alt="Product">
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info mt-4">
                        <div class="top-info">
                            <div class="reviews"><i class="fa-solid fa-star"></i> (11.6k Reviews)</div>
                        </div>
                        <div class="bottom-info">
                            <div class="left">
                                <h3>Product Heading Here</h3>
                                <p class="price">$349 <span class="sold-out">Sold Out 85%</span></p>
                            </div>
                            <button class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></button>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="assets/images/prodict-img1.png" alt="Product">
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info mt-4">
                        <div class="top-info">
                            <div class="reviews"><i class="fa-solid fa-star"></i> (11.6k Reviews)</div>
                        </div>
                        <div class="bottom-info">
                            <div class="left">
                                <h3>Product Heading Here</h3>
                                <p class="price">$349 <span class="sold-out">Sold Out 85%</span></p>
                            </div>
                            <button class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Custom Arrows -->
            <div class="custom-arrows">
                <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
    </section>
@endsection