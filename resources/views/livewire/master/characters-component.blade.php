@push('css')
<style>
.pagination-top {
    margin-bottom: 50px; /* Atur jarak sesuai keinginan */
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

.blog_content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>
@endpush

<div>
    <!-- Search bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control" placeholder="Search characters..." wire:model="search">
            </div>
        </div>
    </div>

    <!-- Pagination atas -->
    <div class="row">
        <div class="col-12 mt-2 mt-md-4 d-flex justify-content-center pagination-top">
            <ul class="pagination pagination_style1 pagination-red">
                {{ $characters->links() }}
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @foreach ($characters as $character)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="blog_post blog_style2 box_shadow1 card-h100">
                        <div class="card-img-container">
                            <a href="{{ route('character.detail', ['id' => $character->id]) }}">
                                <img src="{{ asset('storage/' . $character->image) }}" alt="{{ $character->name }}">
                            </a>
                        </div>
                        <div class="blog_content bg-white">
                            <div class="blog_text">
                                <h6 class="blog_title"><a href="{{ route('character.detail', ['id' => $character->id]) }}">{{ $character->name }}</a></h6>
                                <ul class="list_none blog_meta">
                                    <li><a href="#"><i class="ti-calendar"></i> {{ $character->created_at }}</a></li>
                                </ul>
                                <p>
                                    {!! Str::limit(strip_tags($character->description), 100) !!}
                                    @if (strlen(strip_tags($character->description)) > 100)
                                        <a href="{{ route('character.detail', $character->id) }}">Read more</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 mt-2 mt-md-4 d-flex justify-content-center">
                <ul class="pagination pagination_style1 pagination-red">
                    {{ $characters->links() }}
                </ul>
            </div>
        </div>
    </div>
</div>
