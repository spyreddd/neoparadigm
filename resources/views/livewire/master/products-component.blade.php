@push('css')
<style>
.pagination-top {
    margin-bottom: 50px; /* Atur jarak sesuai keinginan */
}
</style>
@endpush

@push('js')
    <script>
        if ($(".loadmore").length > 0) {
            $(".loadmore").isotope({
                layoutMode: 'fitRows',
                itemSelector: '.grid_item',
                percentPosition: true,
            });
        }
        window.addEventListener('loadmore', function() {
            $('.loadmore').isotope('destroy');
            if ($(".loadmore").length > 0) {
                $(".loadmore").isotope({
                    layoutMode: 'fitRows',
                    itemSelector: '.grid_item',
                    percentPosition: true,
                });
            }
            var elementHeight = $('.loadmore').height();
            $(window).scrollTop(elementHeight-600);
        });
    </script>
@endpush

<div>
    <!-- Pagination atas -->
    <div class="row">
        <div class="col-12 mt-2 mt-md-4 d-flex justify-content-center pagination-top">
            <ul class="pagination pagination_style1 pagination-red">
                {{ $products->links() }}
            </ul>
        </div>
    </div>

    <!-- Daftar produk -->
    <div class="row loadmore">
        @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-6 grid_item">
                <div class="product">
                    <div class="product_img">
                        <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li class="add-to-cart"><a href="#" wire:click.prevent="addCart({{ $product->id }})"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="{{ route('product.detail', ['id' => $product->id]) }}">{{ $product->name }}</a></h6>
                        <div class="product_price">
                            <span class="price">@rupiah($product->price)</span>
                        </div>
                        <div class="pr_desc">
                            <p>{{ Str::limit(strip_tags($product->description), 100) }}</p>
                        </div>
                        <div class="list_product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li class="add-to-cart" wire:click.prevent="addCart({{ $product->id }})"><a href="javascript:void(0)"><i class="icon-basket-loaded"></i> Add</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination bawah -->
    <div class="row">
        <div class="col-12 mt-2 mt-md-4 d-flex justify-content-center">
            <ul class="pagination pagination_style1 pagination-red">
                {{ $products->links() }}
            </ul>
        </div>
    </div>
</div>

