@extends('customer.layout')

@section('title', 'Trang chủ - TechStore')
@section('description', 'Cửa hàng bán điện thoại, laptop, phụ kiện và thiết bị gia dụng chính hãng với giá tốt nhất')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Công nghệ hàng đầu<br>
                    <span class="text-warning">Giá tốt nhất</span>
                </h1>
                <p class="lead mb-4">
                    Khám phá bộ sưu tập điện thoại, laptop, phụ kiện và thiết bị gia dụng chính hãng 
                    với ưu đãi hấp dẫn tại TechStore.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg px-4">
                        <i class="ri-shopping-bag-line me-2"></i>Mua ngay
                    </a>
                    <a href="#categories" class="btn btn-outline-light btn-lg px-4">
                        <i class="ri-arrow-down-line me-2"></i>Khám phá
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="/images/hero-banner.png" alt="TechStore" class="img-fluid" style="max-width: 500px;">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5" id="categories">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Danh mục sản phẩm</h2>
            <p class="text-muted">Lựa chọn đa dạng cho mọi nhu cầu</p>
        </div>
        
        <div class="row g-4">
            @foreach($danhMuc as $category)
                <div class="col-md-3">
                    <a href="{{ route('products.category', $category->id) }}" class="category-card d-block h-100">
                        <div class="category-icon">
                            @switch($category->ten_loai)
                                @case('Điện thoại')
                                    <i class="ri-smartphone-line"></i>
                                    @break
                                @case('Laptop')
                                    <i class="ri-computer-line"></i>
                                    @break
                                @case('Phụ kiện')
                                    <i class="ri-headphone-line"></i>
                                    @break
                                @case('Thiết bị gia dụng')
                                    <i class="ri-home-wifi-line"></i>
                                    @break
                                @default
                                    <i class="ri-store-line"></i>
                            @endswitch
                        </div>
                        <h5 class="fw-bold">{{ $category->ten_loai }}</h5>
                        <p class="text-muted mb-0">{{ $category->san_phams_count }} sản phẩm</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($sanPhamNoiBat->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Sản phẩm nổi bật</h2>
                <p class="text-muted mb-0">Được yêu thích nhất</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'popular']) }}" class="btn btn-outline-primary">
                Xem tất cả <i class="ri-arrow-right-line ms-1"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($sanPhamNoiBat as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @include('customer.components.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- New Products -->
@if($sanPhamMoi->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Sản phẩm mới</h2>
                <p class="text-muted mb-0">Vừa cập nhật</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="btn btn-outline-primary">
                Xem tất cả <i class="ri-arrow-right-line ms-1"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($sanPhamMoi as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @include('customer.components.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Sale Products -->
@if($sanPhamGiamGia->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="ri-fire-line text-danger me-2"></i>Giảm giá hot
                </h2>
                <p class="text-muted mb-0">Ưu đãi không thể bỏ lỡ</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'sale']) }}" class="btn btn-outline-danger">
                Xem tất cả <i class="ri-arrow-right-line ms-1"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($sanPhamGiamGia as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @include('customer.components.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Features Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="feature-item">
                    <div class="feature-icon mb-3">
                        <i class="ri-truck-line" style="font-size: 3rem;"></i>
                    </div>
                    <h5>Giao hàng miễn phí</h5>
                    <p class="mb-0">Đơn hàng từ 500K</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-item">
                    <div class="feature-icon mb-3">
                        <i class="ri-secure-payment-line" style="font-size: 3rem;"></i>
                    </div>
                    <h5>Thanh toán an toàn</h5>
                    <p class="mb-0">Bảo mật 100%</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-item">
                    <div class="feature-icon mb-3">
                        <i class="ri-refresh-line" style="font-size: 3rem;"></i>
                    </div>
                    <h5>Đổi trả dễ dàng</h5>
                    <p class="mb-0">Trong vòng 7 ngày</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-item">
                    <div class="feature-icon mb-3">
                        <i class="ri-customer-service-2-line" style="font-size: 3rem;"></i>
                    </div>
                    <h5>Hỗ trợ 24/7</h5>
                    <p class="mb-0">Luôn sẵn sàng giúp bạn</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="fw-bold mb-3">Đăng ký nhận tin</h2>
                <p class="text-muted mb-4">
                    Nhận thông tin về sản phẩm mới và ưu đãi đặc biệt qua email
                </p>
                <form class="row g-3 justify-content-center">
                    <div class="col-md-6">
                        <input type="email" class="form-control form-control-lg" 
                               placeholder="Nhập email của bạn">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ri-mail-send-line me-2"></i>Đăng ký
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
