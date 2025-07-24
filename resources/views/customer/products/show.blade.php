@extends('customer.layout')

@section('title', 'Chi tiết sản phẩm - ' . $sanpham->ten)

@push('styles')
<style>
.product-gallery {
    position: relative;
}

.main-image {
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.gallery-thumbs {
    max-height: 400px;
    overflow-y: auto;
}

.gallery-thumb {
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.gallery-thumb:hover,
.gallery-thumb.active {
    border-color: var(--primary-color);
}

.product-info {
    position: sticky;
    top: 20px;
}

.rating-stars {
    color: #ffc107;
}

.price-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
}

.product-features {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
}

.feature-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #dee2e6;
}

.feature-item:last-child {
    border-bottom: none;
}
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            @if($sanpham->loaiSanPham)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.category', $sanpham->loaiSanPham->id) }}">
                        {{ $sanpham->loaiSanPham->ten_loai }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $sanpham->ten }}</li>
        </ol>
    </div>
</nav>

<div class="container py-4">
    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-gallery">
                <!-- Main Image -->
                <div class="main-image-container mb-3">
                    @if($sanpham->hinh_anh)
                        <img id="main-image" src="{{ asset($sanpham->hinh_anh) }}" 
                             alt="{{ $sanpham->ten }}" class="img-fluid main-image w-100" 
                             style="height: 400px; object-fit: cover;">
                    @else
                        <img id="main-image" src="/images/no-image.png" 
                             alt="No image" class="img-fluid main-image w-100 bg-light"
                             style="height: 400px; object-fit: cover;">
                    @endif
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($sanpham->hinh_anh_bo_sung && count($sanpham->hinh_anh_bo_sung) > 0)
                <div class="gallery-thumbs">
                    <div class="row g-2">
                        <!-- Main image thumb -->
                        @if($sanpham->hinh_anh)
                            <div class="col-3">
                                <img src="{{ asset($sanpham->hinh_anh) }}" 
                                     class="img-fluid gallery-thumb active" 
                                     style="height: 80px; object-fit: cover;"
                                     onclick="changeMainImage(this.src)">
                            </div>
                        @endif
                        
                        <!-- Additional images -->
                        @foreach($sanpham->hinh_anh_bo_sung as $image)
                            <div class="col-3">
                                <img src="{{ asset($image) }}" 
                                     class="img-fluid gallery-thumb" 
                                     style="height: 80px; object-fit: cover;"
                                     onclick="changeMainImage(this.src)">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info">
                <!-- Product Name -->
                <h1 class="h3 fw-bold mb-3">{{ $sanpham->ten }}</h1>
                
                <!-- SKU -->
                @if($sanpham->sku)
                    <p class="text-muted mb-3">
                        <i class="ri-barcode-line me-1"></i>Mã sản phẩm: <strong>{{ $sanpham->sku }}</strong>
                    </p>
                @endif
                
                <!-- Rating -->
                @if($sanpham->danh_gia_trung_binh > 0)
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $sanpham->danh_gia_trung_binh)
                                    <i class="ri-star-fill rating-stars"></i>
                                @else
                                    <i class="ri-star-line text-muted"></i>
                                @endif
                            @endfor
                            <span class="ms-2">{{ number_format($sanpham->danh_gia_trung_binh, 1) }}/5</span>
                            <small class="text-muted ms-2">({{ $sanpham->so_luong_danh_gia }} đánh giá)</small>
                        </div>
                    </div>
                @endif
                
                <!-- Views -->
                <p class="text-muted mb-3">
                    <i class="ri-eye-line me-1"></i>{{ number_format($sanpham->luot_xem) }} lượt xem
                </p>
                
                <!-- Price Section -->
                <div class="price-section">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            @if($sanpham->gia_goc && $sanpham->gia_goc > $sanpham->gia)
                                <div class="text-light mb-1" style="text-decoration: line-through; opacity: 0.7;">
                                    {{ number_format($sanpham->gia_goc) }}đ
                                </div>
                                <h2 class="mb-0 text-warning">{{ number_format($sanpham->gia) }}đ</h2>
                            @else
                                <h2 class="mb-0 text-white">{{ number_format($sanpham->gia) }}đ</h2>
                            @endif
                        </div>
                        
                        @if($sanpham->gia_goc && $sanpham->gia_goc > $sanpham->gia)
                            <div class="badge bg-danger fs-6">
                                -{{ round((($sanpham->gia_goc - $sanpham->gia) / $sanpham->gia_goc) * 100) }}%
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Stock Status -->
                <div class="mb-4">
                    @if($sanpham->so_luong_ton_kho > 0)
                        <div class="alert alert-success">
                            <i class="ri-checkbox-circle-line me-2"></i>
                            <strong>Còn hàng</strong> - {{ $sanpham->so_luong_ton_kho }} sản phẩm có sẵn
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="ri-close-circle-line me-2"></i>
                            <strong>Hết hàng</strong>
                        </div>
                    @endif
                </div>
                
                <!-- Add to Cart -->
                <div class="mb-4">
                    @if($sanpham->so_luong_ton_kho > 0)
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg add-to-cart" data-product-id="{{ $sanpham->id }}">
                                <i class="ri-shopping-cart-line me-2"></i>Thêm vào giỏ hàng
                            </button>
                            <button class="btn btn-outline-primary btn-lg">
                                <i class="ri-heart-line me-2"></i>Yêu thích
                            </button>
                        </div>
                    @else
                        <div class="d-grid">
                            <button class="btn btn-secondary btn-lg" disabled>
                                <i class="ri-close-line me-2"></i>Hết hàng
                            </button>
                        </div>
                    @endif
                </div>
                
                <!-- Quick Actions -->
                <div class="d-flex gap-2 mb-4">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="ri-share-line me-1"></i>Chia sẻ
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="ri-scales-line me-1"></i>So sánh
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="ri-question-line me-1"></i>Hỏi đáp
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Details Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                            data-bs-target="#description" type="button" role="tab">
                        <i class="ri-file-text-line me-1"></i>Mô tả
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" 
                            data-bs-target="#specifications" type="button" role="tab">
                        <i class="ri-settings-line me-1"></i>Thông số kỹ thuật
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                            data-bs-target="#reviews" type="button" role="tab">
                        <i class="ri-star-line me-1"></i>Đánh giá ({{ $sanpham->so_luong_danh_gia }})
                    </button>
                </li>
            </ul>
            
            <div class="tab-content border border-top-0 p-4" id="productTabsContent">
                <!-- Description -->
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    @if($sanpham->mo_ta)
                        <h5>Mô tả sản phẩm</h5>
                        <p>{{ $sanpham->mo_ta }}</p>
                    @endif
                    
                    @if($sanpham->mo_ta_chi_tiet)
                        <h5 class="mt-4">Mô tả chi tiết</h5>
                        <div>{!! nl2br(e($sanpham->mo_ta_chi_tiet)) !!}</div>
                    @endif
                    
                    @if(!$sanpham->mo_ta && !$sanpham->mo_ta_chi_tiet)
                        <p class="text-muted">Chưa có mô tả chi tiết cho sản phẩm này.</p>
                    @endif
                </div>
                
                <!-- Specifications -->
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <div class="product-features">
                        <div class="row">
                            <div class="col-md-6">
                                @if($sanpham->hang_san_xuat)
                                    <div class="feature-item">
                                        <span><i class="ri-building-line me-2"></i>Hãng sản xuất:</span>
                                        <strong>{{ $sanpham->hang_san_xuat }}</strong>
                                    </div>
                                @endif
                                
                                @if($sanpham->xuat_xu)
                                    <div class="feature-item">
                                        <span><i class="ri-earth-line me-2"></i>Xuất xứ:</span>
                                        <strong>{{ $sanpham->xuat_xu }}</strong>
                                    </div>
                                @endif
                                
                                @if($sanpham->mau_sac)
                                    <div class="feature-item">
                                        <span><i class="ri-palette-line me-2"></i>Màu sắc:</span>
                                        <strong>{{ $sanpham->mau_sac }}</strong>
                                    </div>
                                @endif
                                
                                @if($sanpham->chat_lieu)
                                    <div class="feature-item">
                                        <span><i class="ri-shape-line me-2"></i>Chất liệu:</span>
                                        <strong>{{ $sanpham->chat_lieu }}</strong>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-md-6">
                                @if($sanpham->trong_luong)
                                    <div class="feature-item">
                                        <span><i class="ri-weight-line me-2"></i>Trọng lượng:</span>
                                        <strong>{{ $sanpham->trong_luong }} kg</strong>
                                    </div>
                                @endif
                                
                                @if($sanpham->kich_thuoc)
                                    <div class="feature-item">
                                        <span><i class="ri-ruler-2-line me-2"></i>Kích thước:</span>
                                        <strong>{{ $sanpham->kich_thuoc }}</strong>
                                    </div>
                                @endif
                                
                                @if($sanpham->loaiSanPham)
                                    <div class="feature-item">
                                        <span><i class="ri-list-check me-2"></i>Danh mục:</span>
                                        <strong>{{ $sanpham->loaiSanPham->ten_loai }}</strong>
                                    </div>
                                @endif
                                
                                <div class="feature-item">
                                    <span><i class="ri-calendar-line me-2"></i>Ngày thêm:</span>
                                    <strong>{{ $sanpham->created_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reviews -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="text-center py-5">
                        <i class="ri-star-line display-1 text-muted"></i>
                        <h5 class="mt-3">Chưa có đánh giá</h5>
                        <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                        <button class="btn btn-primary">
                            <i class="ri-edit-line me-1"></i>Viết đánh giá
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($sanphamLienQuan->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">
                <i class="ri-links-line me-2"></i>Sản phẩm liên quan
            </h3>
            <div class="row g-4">
                @foreach($sanphamLienQuan->take(4) as $product)
                    <div class="col-lg-3 col-md-6">
                        @include('customer.components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    
    <!-- Same Brand Products -->
    @if($sanphamCungHang->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">
                <i class="ri-building-line me-2"></i>Cùng thương hiệu {{ $sanpham->hang_san_xuat }}
            </h3>
            <div class="row g-4">
                @foreach($sanphamCungHang as $product)
                    <div class="col-lg-3 col-md-6">
                        @include('customer.components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function changeMainImage(src) {
    document.getElementById('main-image').src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.gallery-thumb').forEach(thumb => {
        thumb.classList.remove('active');
    });
    event.target.classList.add('active');
}

// Add to cart functionality
document.addEventListener('click', function(e) {
    if (e.target.closest('.add-to-cart')) {
        e.preventDefault();
        const productId = e.target.closest('.add-to-cart').dataset.productId;
        
        // Show success message
        showToast('Sản phẩm đã được thêm vào giỏ hàng!', 'success');
        
        // Update cart count
        const cartCount = document.getElementById('cart-count');
        cartCount.textContent = parseInt(cartCount.textContent) + 1;
    }
});
</script>
@endpush
@endsection
