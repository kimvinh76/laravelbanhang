@extends('customer.layout')

@section('title', $category->ten_loai . ' - Danh mục sản phẩm')

@push('styles')
<style>
.category-banner {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 60px 0;
    margin-bottom: 40px;
}

.category-description {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
}

.product-grid {
    min-height: 600px;
}

.empty-category {
    text-align: center;
    padding: 100px 0;
}
</style>
@endpush

@section('content')
<!-- Category Banner -->
<div class="category-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb text-white-50">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-white text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('products.index') }}" class="text-white text-decoration-none">Sản phẩm</a>
                        </li>
                        <li class="breadcrumb-item active text-white">{{ $category->ten_loai }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">{{ $category->ten_loai }}</h1>
                
                @if($category->mo_ta)
                    <p class="lead mb-0">{{ $category->mo_ta }}</p>
                @endif
                
                <div class="mt-3">
                    <span class="badge bg-light text-dark me-2">
                        <i class="ri-package-line me-1"></i>{{ $products->total() }} sản phẩm
                    </span>
                    <span class="badge bg-light text-dark">
                        <i class="ri-eye-line me-1"></i>Xem tất cả
                    </span>
                </div>
            </div>
            
            <div class="col-lg-4 text-center">
                <div class="category-icon">
                    <i class="ri-shopping-bag-line display-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Filter and Sort Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <!-- Filter Toggle -->
                <div>
                    <button class="btn btn-outline-primary d-lg-none" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#mobileFilters">
                        <i class="ri-filter-line me-1"></i>Bộ lọc
                    </button>
                </div>
                
                <!-- Sort Options -->
                <div class="d-flex align-items-center gap-3">
                    <label class="form-label mb-0">Sắp xếp:</label>
                    <select class="form-select" id="sortSelect" style="width: auto;">
                        <option value="">Mặc định</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="collapse d-lg-block" id="mobileFilters">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ri-filter-line me-2"></i>Bộ lọc
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" method="GET">
                            <!-- Price Range -->
                            <div class="mb-4">
                                <h6 class="fw-bold">Khoảng giá</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" 
                                               name="min_price" placeholder="Từ" 
                                               value="{{ request('min_price') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" 
                                               name="max_price" placeholder="Đến"
                                               value="{{ request('max_price') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Brand Filter -->
                            @if($brands->count() > 0)
                            <div class="mb-4">
                                <h6 class="fw-bold">Thương hiệu</h6>
                                <div class="max-height-200 overflow-auto">
                                    @foreach($brands as $brand)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="brands[]" value="{{ $brand }}"
                                                   id="brand_{{ $loop->index }}"
                                                   {{ in_array($brand, request('brands', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="brand_{{ $loop->index }}">
                                                {{ $brand }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Color Filter -->
                            @if($colors->count() > 0)
                            <div class="mb-4">
                                <h6 class="fw-bold">Màu sắc</h6>
                                <div class="max-height-200 overflow-auto">
                                    @foreach($colors as $color)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="colors[]" value="{{ $color }}"
                                                   id="color_{{ $loop->index }}"
                                                   {{ in_array($color, request('colors', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="color_{{ $loop->index }}">
                                                {{ $color }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Material Filter -->
                            @if($materials->count() > 0)
                            <div class="mb-4">
                                <h6 class="fw-bold">Chất liệu</h6>
                                <div class="max-height-200 overflow-auto">
                                    @foreach($materials as $material)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="materials[]" value="{{ $material }}"
                                                   id="material_{{ $loop->index }}"
                                                   {{ in_array($material, request('materials', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="material_{{ $loop->index }}">
                                                {{ $material }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Stock Status -->
                            <div class="mb-4">
                                <h6 class="fw-bold">Tình trạng</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           name="in_stock" value="1" id="in_stock"
                                           {{ request('in_stock') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="in_stock">
                                        Còn hàng
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           name="on_sale" value="1" id="on_sale"
                                           {{ request('on_sale') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="on_sale">
                                        Đang khuyến mãi
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Filter Actions -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-search-line me-1"></i>Áp dụng
                                </button>
                                <a href="{{ route('products.category', $category->id) }}" class="btn btn-outline-secondary">
                                    <i class="ri-refresh-line me-1"></i>Xóa bộ lọc
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            @if($products->count() > 0)
                <!-- Results Info -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="text-muted mb-0">
                        Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }} 
                        trong tổng số {{ $products->total() }} sản phẩm
                    </p>
                    
                    <!-- View Mode Toggle -->
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="viewMode" id="gridView" checked>
                        <label class="btn btn-outline-secondary btn-sm" for="gridView">
                            <i class="ri-grid-fill"></i>
                        </label>
                        <input type="radio" class="btn-check" name="viewMode" id="listView">
                        <label class="btn btn-outline-secondary btn-sm" for="listView">
                            <i class="ri-list-check"></i>
                        </label>
                    </div>
                </div>
                
                <!-- Products Grid -->
                <div class="product-grid" id="productsContainer">
                    <div class="row g-4" id="gridView-content">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6">
                                @include('customer.components.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- List View (Hidden by default) -->
                    <div id="listView-content" style="display: none;">
                        @foreach($products as $product)
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        @if($product->hinh_anh)
                                            <img src="{{ asset($product->hinh_anh) }}" 
                                                 class="img-fluid rounded-start h-100" 
                                                 style="object-fit: cover;" alt="{{ $product->ten }}">
                                        @else
                                            <div class="bg-light h-100 d-flex align-items-center justify-content-center">
                                                <i class="ri-image-line text-muted display-4"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title">{{ $product->ten }}</h5>
                                                    <p class="card-text">{{ Str::limit($product->mo_ta, 150) }}</p>
                                                    
                                                    <div class="mb-2">
                                                        @if($product->gia_goc && $product->gia_goc > $product->gia)
                                                            <span class="text-decoration-line-through text-muted me-2">
                                                                {{ number_format($product->gia_goc) }}đ
                                                            </span>
                                                        @endif
                                                        <span class="h5 text-primary">{{ number_format($product->gia) }}đ</span>
                                                    </div>
                                                    
                                                    <small class="text-muted">
                                                        <i class="ri-eye-line me-1"></i>{{ number_format($product->luot_xem) }} lượt xem
                                                    </small>
                                                </div>
                                                
                                                <div class="text-end">
                                                    <div class="btn-group-vertical">
                                                        <a href="{{ route('products.show', $product->id) }}" 
                                                           class="btn btn-outline-primary btn-sm">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                        <button class="btn btn-primary btn-sm add-to-cart" 
                                                                data-product-id="{{ $product->id }}"
                                                                {{ $product->so_luong_ton_kho <= 0 ? 'disabled' : '' }}>
                                                            <i class="ri-shopping-cart-line"></i>
                                                        </button>
                                                        <button class="btn btn-outline-secondary btn-sm">
                                                            <i class="ri-heart-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                @endif
                
            @else
                <!-- Empty State -->
                <div class="empty-category">
                    <i class="ri-inbox-line display-1 text-muted"></i>
                    <h3 class="mt-3">Không có sản phẩm nào</h3>
                    <p class="text-muted">Danh mục này hiện chưa có sản phẩm nào.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="ri-arrow-left-line me-1"></i>Xem tất cả sản phẩm
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Sort functionality
document.getElementById('sortSelect').addEventListener('change', function() {
    const url = new URL(window.location);
    if (this.value) {
        url.searchParams.set('sort', this.value);
    } else {
        url.searchParams.delete('sort');
    }
    window.location = url;
});

// View mode toggle
document.querySelectorAll('input[name="viewMode"]').forEach(input => {
    input.addEventListener('change', function() {
        const gridContent = document.getElementById('gridView-content');
        const listContent = document.getElementById('listView-content');
        
        if (this.id === 'gridView') {
            gridContent.style.display = 'block';
            listContent.style.display = 'none';
        } else {
            gridContent.style.display = 'none';
            listContent.style.display = 'block';
        }
    });
});

// Filter form auto-submit on change
document.querySelectorAll('#filterForm input[type="checkbox"], #filterForm input[type="number"]').forEach(input => {
    input.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
@endpush
@endsection
