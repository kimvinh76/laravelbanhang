@extends('customer.layout')

@section('title', 'Danh mục sản phẩm')

@push('styles')
<style>
.category-hero {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 80px 0;
}

.category-item {
    background: white;
    border-radius: 15px;
    padding: 30px 20px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: none;
    height: 100%;
}

.category-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    text-decoration: none;
}

.category-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2.5rem;
    color: white;
}

.category-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}

.category-count {
    color: #6c757d;
    font-size: 0.9rem;
}

.category-colors {
    --color-1: #667eea;
    --color-2: #764ba2;
    --color-3: #f093fb;
    --color-4: #f5576c;
    --color-5: #4facfe;
    --color-6: #00f2fe;
    --color-7: #43e97b;
    --color-8: #38f9d7;
    --color-9: #ffecd2;
    --color-10: #fcb69f;
}

.search-categories {
    max-width: 500px;
    margin: 0 auto;
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="category-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Danh mục sản phẩm</h1>
                <p class="lead mb-4">
                    Khám phá các danh mục sản phẩm đa dạng với hàng nghìn lựa chọn
                    
                </p>
                
                <!-- Search Categories -->
                <div class="search-categories">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" placeholder="Tìm kiếm danh mục..." 
                               id="categorySearch">
                        <button class="btn btn-light" type="button">
                            <i class="ri-search-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid -->
<section class="py-5">
    <div class="container">
        @if($categories->count() > 0)
            <!-- Stats -->
            <div class="row mb-5">
                <div class="col-lg-12 text-center">
                    <h2 class="fw-bold mb-3">{{ $categories->count() }} danh mục sản phẩm</h2>
                    <p class="text-muted lead">
                        Tổng cộng {{ $totalProducts }} sản phẩm trên toàn bộ danh mục
                    </p>
                </div>
            </div>
            
            <!-- Categories Grid -->
            <div class="row g-4" id="categoriesGrid">
                @php
                    $colors = [
                        ['#667eea', '#764ba2'],
                        ['#f093fb', '#f5576c'], 
                        ['#4facfe', '#00f2fe'],
                        ['#43e97b', '#38f9d7'],
                        ['#ffecd2', '#fcb69f'],
                        ['#ff9a9e', '#fecfef'],
                        ['#a8edea', '#fed6e3'],
                        ['#fbc2eb', '#a6c1ee'],
                        ['#fdbb2d', '#22c1c3'],
                        ['#ff7e5f', '#feb47b']
                    ];
                @endphp
                
                @foreach($categories as $index => $category)
                    @php $colorIndex = $index % count($colors); @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6 category-card">
                        <a href="{{ route('products.category', $category->id) }}" class="category-item d-block">
                            <div class="category-icon" 
                                 style="background: linear-gradient(135deg, {{ $colors[$colorIndex][0] }} 0%, {{ $colors[$colorIndex][1] }} 100%);">
                                @switch($category->ten_loai)
                                    @case('Điện thoại')
                                        <i class="ri-smartphone-line"></i>
                                        @break
                                    @case('Laptop')
                                        <i class="ri-computer-line"></i>
                                        @break
                                    @case('Máy tính bảng')
                                        <i class="ri-tablet-line"></i>
                                        @break
                                    @case('Phụ kiện')
                                        <i class="ri-headphone-line"></i>
                                        @break
                                    @case('Thời trang')
                                        <i class="ri-shirt-line"></i>
                                        @break
                                    @case('Giày dép')
                                        <i class="ri-run-line"></i>
                                        @break
                                    @case('Túi xách')
                                        <i class="ri-handbag-line"></i>
                                        @break
                                    @case('Mỹ phẩm')
                                        <i class="ri-magic-line"></i>
                                        @break
                                    @case('Gia dụng')
                                        <i class="ri-home-4-line"></i>
                                        @break
                                    @case('Thể thao')
                                        <i class="ri-football-line"></i>
                                        @break
                                    @case('Sách')
                                        <i class="ri-book-line"></i>
                                        @break
                                    @case('Đồ chơi')
                                        <i class="ri-gamepad-line"></i>
                                        @break
                                    @default
                                        <i class="ri-shopping-bag-line"></i>
                                @endswitch
                            </div>
                            
                            <div class="category-title">{{ $category->ten_loai }}</div>
                            
                            <div class="category-count">
                                <i class="ri-archive-line me-1"></i>
                                {{ $category->sanphams_count }} sản phẩm
                            </div>
                            
                            @if($category->mo_ta)
                                <p class="small text-muted mt-2 mb-0">
                                    {{ Str::limit($category->mo_ta, 60) }}
                                </p>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
            
            <!-- No Results Message (Hidden by default) -->
            <div id="noResults" style="display: none;">
                <div class="text-center py-5">
                    <i class="ri-search-line display-1 text-muted"></i>
                    <h3 class="mt-3">Không tìm thấy danh mục</h3>
                    <p class="text-muted">Thử tìm kiếm với từ khóa khác</p>
                </div>
            </div>
            
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="ri-folder-line display-1 text-muted"></i>
                <h3 class="mt-3">Chưa có danh mục nào</h3>
                <p class="text-muted">Hệ thống chưa có danh mục sản phẩm nào.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="ri-arrow-left-line me-1"></i>Về trang chủ
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Popular Categories -->
@if($popularCategories->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12 text-center">
                <h2 class="fw-bold">Danh mục phổ biến</h2>
                <p class="text-muted">Những danh mục được quan tâm nhiều nhất</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($popularCategories as $index => $category)
                @php $colorIndex = $index % count($colors); @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="category-icon" style="width: 60px; height: 60px; font-size: 1.5rem;
                                         background: linear-gradient(135deg, {{ $colors[$colorIndex][0] }} 0%, {{ $colors[$colorIndex][1] }} 100%);">
                                        <i class="ri-fire-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">{{ $category->ten_loai }}</h5>
                                    <p class="mb-1 text-muted">{{ $category->sanphams_count }} sản phẩm</p>
                                    <small class="text-success">
                                        <i class="ri-trending-up-line me-1"></i>Phổ biến
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('products.category', $category->id) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        Xem <i class="ri-arrow-right-line ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="fw-bold mb-4">Không tìm thấy danh mục phù hợp?</h2>
                <p class="lead mb-4">
                    Liên hệ với chúng tôi để được tư vấn và hỗ trợ tìm kiếm sản phẩm
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">
                        <i class="ri-customer-service-line me-2"></i>Liên hệ tư vấn
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="ri-search-line me-2"></i>Tìm kiếm sản phẩm
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Search categories functionality
document.getElementById('categorySearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const categoryCards = document.querySelectorAll('.category-card');
    const noResults = document.getElementById('noResults');
    let visibleCount = 0;
    
    categoryCards.forEach(card => {
        const categoryTitle = card.querySelector('.category-title').textContent.toLowerCase();
        
        if (categoryTitle.includes(searchTerm)) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    if (visibleCount === 0 && searchTerm !== '') {
        noResults.style.display = 'block';
    } else {
        noResults.style.display = 'none';
    }
});

// Clear search on enter
document.getElementById('categorySearch').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
    }
});
</script>
@endpush
@endsection
