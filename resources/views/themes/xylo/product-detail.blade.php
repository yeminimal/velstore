
@extends('themes.xylo.layouts.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"> 
@endsection
@section('content')
@php $currency = activeCurrency(); @endphp
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
                @if ($product->stock > 0)
                    <div class="mb-2 mt-3 btnss">IN STOCK</div>
                @else
                    <div class="mb-2 mt-3 btnss text-danger">OUT OF STOCK</div>
                @endif
                @php
                    $averageRating = round($product->reviews_avg_rating, 1);
                @endphp
                <div class="stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($averageRating))
                            <i class="fa-solid fa-star text-warning"></i>
                        @elseif ($i - 0.5 == $averageRating)
                            <i class="fa-solid fa-star-half-alt text-warning"></i>
                        @else
                            <i class="fa-regular fa-star text-muted"></i>
                        @endif
                    @endfor
                    <span class="spanstar"> ({{ $product->reviews_count }} customer reviews)</span>
                </div>
                <h1 class="sec-heading">{{ $product->translation->name }}</h1>
                <h2 id="variant-price" >{{ $currency->symbol }}{{ $product->primaryVariant->converted_price ?? 'N/A' }}</h2>
                <p>{{ $product->translation->short_description }}</p>

                <!--
                <div id="product-attributes" class="product-options">
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
                </div>-->

                <div id="product-attributes" class="product-options">
                    @php
                        $groupedAttributes = $product->attributeValues->groupBy(fn($item) => $item->attribute->name);
                    @endphp

                    @foreach ($groupedAttributes as $attributeName => $values)
                        <div class="attribute-options mt-3">
                            <h3>{{ $attributeName }}</h3>
                            <div class="{{ strtolower($attributeName) }}-wrapper">
                                @foreach ($values as $index => $value)
                                    @php
                                        $inputId = strtolower($attributeName) . '-' . $index;
                                    @endphp
                                    <input 
                                        type="radio" 
                                        name="{{ strtolower($attributeName) }}" 
                                        id="{{ $inputId }}"
                                        value="{{ $value->id }}"
                                        {{ $index === 0 ? 'checked' : '' }}
                                    >
                                    <label 
                                        for="{{ $inputId }}" 
                                        class="{{ strtolower($attributeName) === 'color' ? 'color-circle ' . strtolower($value->translated_value) : 'size-box' }}"
                                    >
                                        @if(strtolower($attributeName)  == 'size')
                                            {{ $value->translated_value }}
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Quantity Selector and Cart Button -->
                <div class="cart-actions mt-3 d-flex">
                    <div class="quantity me-4">
                        <button onclick="changeQty(-1)">-</button>
                        <input type="text" id="qty" value="1">
                        <button onclick="changeQty(1)">+</button>
                    </div>
                    <button class="add-to-cart read-more" onclick="addToCart({{ $product->id }})">Add to Cart</button>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@php
    $variants = $product->variants->map(function ($variant) {
        return [
            'id' => $variant->id,
            'price' => $variant->converted_price,
            'discount_price' => $variant->converted_discount_price,
            'attribute_value_ids' => $variant->attributeValues->pluck('id')->sort()->values()->all()
        ];
    });
@endphp

    <script>
        const variants = @json($variants);
        const currencySymbol = '{{ $currency->symbol }}';
    </script>

<script>
    $(document).ready(function () {
        function updateVariantPrice() {
            let selectedAttributeIds = [];

            // Collect selected radio inputs
            $('#product-attributes input[type=radio]:checked').each(function () {
                selectedAttributeIds.push(parseInt($(this).val()));
            });

            // Sort for consistent comparison
            selectedAttributeIds.sort();

            // Debug: check selected attributes
            console.log('Selected Attribute IDs:', selectedAttributeIds);

            // Find matching variant
            let matchedVariant = variants.find(variant =>
                JSON.stringify(variant.attribute_value_ids) === JSON.stringify(selectedAttributeIds)
            );

            // Update price
            if (matchedVariant) {
                if (matchedVariant.discount_price) {
                    $('#variant-price').html(
                        `${currencySymbol}${matchedVariant.discount_price} <del>${currencySymbol}${matchedVariant.price}</del>`
                    );
                } else {
                    $('#variant-price').text(`${currencySymbol}${matchedVariant.price}`);
                }
            } else {
                // Fallback to primary variant
                $('#variant-price').text(`${currencySymbol}{{ $product->primaryVariant->converted_price }}`);
            }
        }

        // Trigger on change
        $('#product-attributes input[type=radio]').on('change', updateVariantPrice);

        // Trigger on load
        updateVariantPrice();
    });
</script>



    <script>
       /* $(document).ready(function () {
            function updateVariantPrice() {
                let selectedAttributeIds = [];

                // Get all checked radio inputs inside #product-attributes
                $('#product-attributes input[type=radio]:checked').each(function () {
                    selectedAttributeIds.push(parseInt($(this).val()));
                });

                // Sort to match structure
                selectedAttributeIds.sort();

                // Find matching variant
                let matchedVariant = variants.find(variant =>
                    JSON.stringify(variant.attribute_value_ids) === JSON.stringify(selectedAttributeIds)
                );

                // Update price
                if (matchedVariant) {
                    if (matchedVariant.discount_price) {
                        $('#variant-price').html(`${currencySymbol}${matchedVariant.discount_price} <del>${currencySymbol}${matchedVariant.price}</del>`);
                    } else {
                        $('#variant-price').text(`${currencySymbol}${matchedVariant.price}`);
                    }
                } else {
                    $('#variant-price').text('N/A');
                }
            }

            // Trigger on change
            $('#product-attributes input[type=radio]').on('change', updateVariantPrice); 

            // Trigger on page load
             updateVariantPrice(); 
        });*/
    </script>



















    <script>
        function changeQty(amount) {
            let qtyInput = document.getElementById("qty");
            let currentQty = parseInt(qtyInput.value);
            let newQty = currentQty + amount;

            if (newQty < 1) newQty = 1; // Prevent going below 1
            qtyInput.value = newQty;
        }
        function addToCart(productId) {
            let quantity = document.getElementById("qty").value;

            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                toastr.success("{{ session('success') }}", data.message, {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
                updateCartCount(data.cart);
            })
            .catch(error => console.error("Error:", error));
        }

        function updateCartCount(cart) {
            let totalCount = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById("cart-count").textContent = totalCount;
        }
    </script>
@endsection