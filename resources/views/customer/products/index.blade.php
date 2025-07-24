@extends('customer.layout')

@section('title', 'Sản phẩm - TechStore')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </div>
</nav>

<div class="container py-4">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar">
                <h5 class="fw-bold mb-3">
                    <i class="ri-filter-line me-2"></i>Bộ lọc
                </h5>
                
                <form id="filter-form" method="GET">
                    <!-- Search -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tìm kiếm</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Nhập tên sản phẩm..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Danh mục</label>
                        <select name="category" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            @foreach($loaiSanPhams as $category)
                                <option value="{{ $category->id }}" 
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->ten_loai }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Khoảng giá</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="min_price" class="form-control form-control-sm" 
                                       placeholder="Từ" value="{{ request('min_price') }}" min="0">
                            </div>
                            <div class="col-6">
                                <input type="number" name="max_price" class="form-control form-control-sm" 
                                       placeholder="Đến" value="{{ request('max_price') }}" min="0">
                            </div>
                        </div>
                        @if(isset($priceRange))
                            <small class="text-muted">
                                Giá: {{ number_format($priceRange->min_price) }} - {{ number_format($priceRange->max_price) }}đ
                            </small>
                        @endif
                    </div>
                    
                    <!-- Brand Filter -->
                    @if($brands->count() > 0)
                    <div class="mb-4">
                        <label class="form-label fw-bold">Thương hiệu</label>
                        <select name="brand" class="form-select">
                            <option value="">Tất cả thương hiệu</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" 
                                        {{ request('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    <!-- Quick Price Filters -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mức giá phổ biến</label>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm price-quick-filter" 
                                    data-min="0" data-max="5000000">Dưới 5 triệu</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm price-quick-filter" 
                                    data-min="5000000" data-max="10000000">5 - 10 triệu</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm price-quick-filter" 
                                    data-min="10000000" data-max="20000000">10 - 20 triệu</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm price-quick-filter" 
                                    data-min="20000000" data-max="">Trên 20 triệu</button>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-filter-line me-1"></i>Áp dụng
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="ri-refresh-line me-1"></i>Đặt lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Products -->
        <div class="col-lg-9">
            <!-- Sort and View Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Sản phẩm</h4>
                    <p class="text-muted mb-0">
                        Hiển thị {{ $sanphams->firstItem() ?? 0 }} - {{ $sanphams->lastItem() ?? 0 }} 
                        trong {{ $sanphams->total() }} sản phẩm
                    </p>
                </div>
                
                <div class="d-flex gap-3 align-items-center">
                    <!-- Items per page -->
                    <div class="d-flex align-items-center">
                        <label class="form-label me-2 mb-0">Hiển thị:</label>
                        <select name="per_page" class="form-select form-select-sm" style="width: auto;" 
                                onchange="changePerPage(this.value)">
                            <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12</option>
                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                        </select>
                    </div>
                    
                    <!-- Sort options -->
                    <div class="d-flex align-items-center">
                        <label class="form-label me-2 mb-0">Sắp xếp:</label>
                        <select name="sort" class="form-select form-select-sm" style="width: auto;" 
                                onchange="changeSort(this.value)">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>A-Z</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            @if($sanphams->count() > 0)
                <div class="row g-4 mb-4">
                    @foreach($sanphams as $product)
                        <div class="col-lg-4 col-md-6">
                            @include('customer.components.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $sanphams->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ri-search-line display-1 text-muted"></i>
                    <h4 class="mt-3">Không tìm thấy sản phẩm</h4>
                    <p class="text-muted">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="ri-refresh-line me-1"></i>Xem tất cả sản phẩm
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function changeSort(sort) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sort);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

// Price quick filters
document.addEventListener('DOMContentLoaded', function() {
    const priceFilters = document.querySelectorAll('.price-quick-filter');
    const minPriceInput = document.querySelector('input[name="min_price"]');
    const maxPriceInput = document.querySelector('input[name="max_price"]');
    
    priceFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const min = this.dataset.min;
            const max = this.dataset.max;
            
            minPriceInput.value = min;
            maxPriceInput.value = max;
            
            // Auto submit form
            document.getElementById('filter-form').submit();
        });
    });
    
    // Add to cart functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-to-cart')) {
            e.preventDefault();
            const productId = e.target.closest('.add-to-cart').dataset.productId;
            
            // This would normally add to cart via AJAX
            // For now, just show a toast
            showToast('Sản phẩm đã được thêm vào giỏ hàng!', 'success');
            
            // Update cart count (mock)
            const cartCount = document.getElementById('cart-count');
            cartCount.textContent = parseInt(cartCount.textContent) + 1;
        }
    });
});
</script>
@endpush
@endsection
