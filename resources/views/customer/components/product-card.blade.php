<div class="product-card h-100">
    <div class="product-image">
        @if($product->hinh_anh)
            <img src="{{ asset($product->hinh_anh) }}" alt="{{ $product->ten }}">
        @else
            <img src="/images/no-image.png" alt="No image" class="bg-light">
        @endif
        
        <!-- Product Badges -->
        <div class="product-badge">
            @if($product->gia_goc && $product->gia_goc > $product->gia)
                <span class="discount-badge">
                    -{{ round((($product->gia_goc - $product->gia) / $product->gia_goc) * 100) }}%
                </span>
            @endif
            
            @if($product->created_at && $product->created_at->gt(now()->subDays(7)))
                <span class="badge bg-success ms-1">Mới</span>
            @endif
            
            @if($product->so_luong_ton_kho == 0)
                <span class="badge bg-danger ms-1">Hết hàng</span>
            @endif
        </div>
        
        <!-- Quick Actions -->
        <div class="product-actions position-absolute bottom-0 start-0 w-100 p-3 d-none">
            <div class="btn-group w-100" role="group">
                <button class="btn btn-outline-white btn-sm" title="Yêu thích">
                    <i class="ri-heart-line"></i>
                </button>
                <button class="btn btn-outline-white btn-sm" title="So sánh">
                    <i class="ri-scales-line"></i>
                </button>
                <button class="btn btn-outline-white btn-sm" title="Xem nhanh">
                    <i class="ri-eye-line"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Category -->
        @if($product->loaiSanPham)
            <small class="text-muted">{{ $product->loaiSanPham->ten_loai }}</small>
        @endif
        
        <!-- Product Name -->
        <h6 class="card-title mb-2">
            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                {{ Str::limit($product->ten, 50) }}
            </a>
        </h6>
        
        <!-- Brand -->
        @if($product->hang_san_xuat)
            <small class="text-muted d-block mb-2">
                <i class="ri-building-line me-1"></i>{{ $product->hang_san_xuat }}
            </small>
        @endif
        
        <!-- Rating -->
        @if($product->danh_gia_trung_binh > 0)
            <div class="mb-2">
                <div class="d-flex align-items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $product->danh_gia_trung_binh)
                            <i class="ri-star-fill text-warning"></i>
                        @else
                            <i class="ri-star-line text-muted"></i>
                        @endif
                    @endfor
                    <small class="text-muted ms-2">({{ $product->so_luong_danh_gia }})</small>
                </div>
            </div>
        @endif
        
        <!-- Price -->
        <div class="price-section mb-3">
            @if($product->gia_goc && $product->gia_goc > $product->gia)
                <div class="price-original">{{ number_format($product->gia_goc) }}đ</div>
            @endif
            <div class="price-sale">{{ number_format($product->gia) }}đ</div>
        </div>
        
        <!-- Features -->
        <div class="product-features mb-3">
            @if($product->mau_sac)
                <small class="badge bg-light text-dark me-1">{{ $product->mau_sac }}</small>
            @endif
            @if($product->trong_luong)
                <small class="badge bg-light text-dark me-1">{{ $product->trong_luong }}kg</small>
            @endif
        </div>
        
        <!-- Stock Status -->
        <div class="stock-status mb-3">
            @if($product->so_luong_ton_kho > 0)
                <small class="text-success">
                    <i class="ri-checkbox-circle-line me-1"></i>Còn {{ $product->so_luong_ton_kho }} sản phẩm
                </small>
            @else
                <small class="text-danger">
                    <i class="ri-close-circle-line me-1"></i>Hết hàng
                </small>
            @endif
        </div>
    </div>
    
    <div class="card-footer bg-white border-top-0">
        <div class="d-grid gap-2">
            @if($product->so_luong_ton_kho > 0)
                <button class="btn btn-primary btn-sm add-to-cart" data-product-id="{{ $product->id }}">
                    <i class="ri-shopping-cart-line me-1"></i>Thêm vào giỏ
                </button>
            @else
                <button class="btn btn-outline-secondary btn-sm" disabled>
                    <i class="ri-close-line me-1"></i>Hết hàng
                </button>
            @endif
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="ri-eye-line me-1"></i>Xem chi tiết
            </a>
        </div>
    </div>
</div>

<style>
.product-card:hover .product-actions {
    display: block !important;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
}

.btn-outline-white {
    color: white;
    border-color: white;
}

.btn-outline-white:hover {
    background-color: white;
    color: #333;
}
</style>
