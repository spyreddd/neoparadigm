@push('css')
<style>
.pagination-top, .pagination-bottom {
    margin-bottom: 50px; /* Adjust the spacing as desired */
}

.pagination-bottom {
    margin-top: 50px; /* Adding top margin to ensure spacing from images */
}

.search-container {
    position: relative;
    max-width: 600px;
    margin: 0 auto 1.5rem;
}

.search-container input {
    width: 100%;
    padding: 12px 20px 12px 50px;
    border: 1px solid #ccc;
    border-radius: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.search-container input:focus {
    border-color: rgba(255, 50, 77);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    outline: none;
}

.search-container .search-icon {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    font-size: 18px;
    color: #aaa;
}

.card-h100 {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card-img-container {
    position: relative;
    width: 100%;
    padding-top: 150%; /* This ratio can be adjusted to match your desired aspect ratio */
    overflow: hidden;
    border-radius: 10px;
    flex-shrink: 0;
}

.card-img-container img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}

.card-img-container img:hover {
    transform: scale(1.05);
}

.product_info {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.category-filter {
    margin-bottom: 30px;
    display: flex;
    justify-content: center;
    gap: 20px;
}

.category-filter button {
    padding: 10px 20px;
    border: none;
    background-color: #f0f0f0;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.category-filter button.active,
.category-filter button:hover {
    background-color: #ff324d;
    color: #fff;
}

/* Ensure there is margin between cards */
.row > .col-xl-4,
.row > .col-md-6,
.row > .col-lg-3,
.row > .col-6 {
    margin-bottom: 20px; /* Adjust as needed */
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
        $(window).scrollTop(elementHeight - 600);
    });

    function filterProducts(category) {
        let items = document.querySelectorAll('.grid_item');
        items.forEach(item => {
            item.style.display = item.dataset.category === category || category === 'all' ? 'block' : 'none';
        });

        document.querySelectorAll('.category-filter button').forEach(button => {
            button.classList.remove('active');
        });

        document.querySelector(`[data-category="${category}"]`).classList.add('active');
    }
</script>
@endpush

<div>
    <!-- Search bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control" placeholder="Search products..." wire:model="search">
            </div>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="category-filter">
        <button wire:click="setCategory('all')" class="@if ($category === 'all') active @endif">All</button>
        <button wire:click="setCategory('softfile')" class="@if ($category === 'softfile') active @endif">Softfiles</button>
        {{-- <button wire:click="setCategory('hardfile')" class="@if ($category === 'hardfile') active @endif">Hardfiles</button> --}}
    </div>

    <!-- Top Pagination -->
    <div class="row">
        <div class="col-12 mt-2 mt-md-4 d-flex justify-content-center pagination-top">
            <ul class="pagination pagination_style1 pagination-red">
                {{ $products->links() }}
            </ul>
        </div>
    </div>

    <!-- Product List -->
    <div class="row loadmore">
        @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-6 grid_item" data-category="{{ $product->category }}">
                <div class="product card-h100">
                    <div class="product_img card-img-container">
                        <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li class="add-to-cart" wire:click.prevent="addCart({{ $product->id }})">
                                    <a href="javascript:void(0)">
                                        <i class="icon-basket-loaded"></i> Add
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title">
                            <a href="{{ route('product.detail', ['id' => $product->id]) }}">{{ $product->name }}</a>
                        </h6>
                        <div class="product_price">
                            <span class="price">@rupiah($product->price)</span>
                        </div>
                        <div class="pr_desc">
                            <p>{{ Str::limit(strip_tags($product->description), 100) }}</p>
                        </div>
                        <div class="list_product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li class="add-to-cart" wire:click.prevent="addCart({{ $product->id }})">
                                    <a href="javascript:void(0)">
                                        <i class="icon-basket-loaded"></i> Add
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Bottom Pagination -->
    <div class="row">
        <div class="col-12 mt-2 mt-md-4 d-flex justify-content-center pagination-bottom">
            <ul class="pagination pagination_style1 pagination-red">
                {{ $products->links() }}
            </ul>
        </div>
    </div>
</div>

<!-- Font Awesome for the search icon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
