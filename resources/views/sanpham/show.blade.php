@extends('layout')

@section('content')
<div class="row">
    <!-- Breadcrumb -->
    <div class="col-12 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('sanpham.index') }}">
                        <i class="ri-home-line me-1"></i>Danh sách sản phẩm
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ $sanpham->ten }}</li>
            </ol>
        </nav>
    </div>

    <!-- Thông tin sản phẩm chính -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <!-- Hình ảnh chính -->
                <div class="text-center mb-3">
                    @if($sanpham->hinh_anh)
                        <img id="main-image" src="{{ asset($sanpham->hinh_anh) }}" 
                             class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                            <i class="ri-image-line" style="font-size: 4rem; color: #6c757d;"></i>
                        </div>
                    @endif
                </div>

                <!-- Gallery ảnh phụ -->
                @if($sanpham->hinh_anh_bo_sung && count($sanpham->hinh_anh_bo_sung) > 0)
                    <div class="row g-2">
                        <div class="col-3">
                            <img src="{{ asset($sanpham->hinh_anh) }}" 
                                 class="img-thumbnail gallery-thumb active" style="cursor: pointer; height: 80px; object-fit: cover;">
                        </div>
                        @foreach($sanpham->hinh_anh_bo_sung as $image)
                            <div class="col-3">
                                <img src="{{ asset($image) }}" 
                                     class="img-thumbnail gallery-thumb" style="cursor: pointer; height: 80px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Thông tin chi tiết -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <!-- Tiêu đề và đánh giá -->
                <div class="mb-3">
                    <h1 class="h3 mb-2">{{ $sanpham->ten }}</h1>
                    @if($sanpham->sku)
                        <p class="text-muted mb-2">
                            <i class="ri-barcode-line me-1"></i>Mã sản phẩm: <strong>{{ $sanpham->sku }}</strong>
                        </p>
                    @endif
                    
                    <!-- Đánh giá -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $sanpham->danh_gia_trung_binh)
                                    <i class="ri-star-fill text-warning"></i>
                                @else
                                    <i class="ri-star-line text-muted"></i>
                                @endif
                            @endfor
                            <span class="ms-1">{{ number_format($sanpham->danh_gia_trung_binh, 1) }}/5</span>
                        </div>
                        <small class="text-muted">({{ $sanpham->so_luong_danh_gia }} đánh giá)</small>
                        <small class="text-muted ms-3">
                            <i class="ri-eye-line me-1"></i>{{ number_format($sanpham->luot_xem) }} lượt xem
                        </small>
                    </div>
                </div>

                <!-- Giá -->
                <div class="mb-4">
                    <div class="d-flex align-items-center">
                        <h2 class="text-success mb-0 me-3">{{ number_format($sanpham->gia) }} VNĐ</h2>
                        @if($sanpham->gia_goc && $sanpham->gia_goc > $sanpham->gia)
                            <span class="text-decoration-line-through text-muted me-2">
                                {{ number_format($sanpham->gia_goc) }} VNĐ
                            </span>
                            <span class="badge bg-danger">-{{ $sanpham->phan_tram_giam_gia }}%</span>
                        @endif
                    </div>
                </div>

                <!-- Thông tin cơ bản -->
                <div class="mb-4">
                    <h5><i class="ri-information-line me-2"></i>Thông tin cơ bản</h5>
                    <div class="row g-2">
                        @if($sanpham->loaiSanPham)
                            <div class="col-md-6">
                                <strong>Loại sản phẩm:</strong> 
                                <span class="badge bg-info">{{ $sanpham->loaiSanPham->ten_loai }}</span>
                            </div>
                        @endif
                        @if($sanpham->hang_san_xuat)
                            <div class="col-md-6"><strong>Hãng:</strong> {{ $sanpham->hang_san_xuat }}</div>
                        @endif
                        @if($sanpham->xuat_xu)
                            <div class="col-md-6"><strong>Xuất xứ:</strong> {{ $sanpham->xuat_xu }}</div>
                        @endif
                        @if($sanpham->mau_sac)
                            <div class="col-md-6"><strong>Màu sắc:</strong> {{ $sanpham->mau_sac }}</div>
                        @endif
                        @if($sanpham->chat_lieu)
                            <div class="col-md-6"><strong>Chất liệu:</strong> {{ $sanpham->chat_lieu }}</div>
                        @endif
                        @if($sanpham->trong_luong)
                            <div class="col-md-6"><strong>Trọng lượng:</strong> {{ $sanpham->trong_luong }} kg</div>
                        @endif
                        @if($sanpham->kich_thuoc)
                            <div class="col-md-6"><strong>Kích thước:</strong> {{ $sanpham->kich_thuoc }}</div>
                        @endif
                    </div>
                </div>

                <!-- Tình trạng kho -->
                <div class="mb-4">
                    <div class="d-flex align-items-center">
                        <strong class="me-3">Tình trạng:</strong>
                        @if($sanpham->trang_thai_hang == 'Còn hàng')
                            <span class="badge bg-success">
                                <i class="ri-check-line me-1"></i>{{ $sanpham->trang_thai_hang }}
                            </span>
                        @elseif($sanpham->trang_thai_hang == 'Sắp hết hàng')
                            <span class="badge bg-warning">
                                <i class="ri-error-warning-line me-1"></i>{{ $sanpham->trang_thai_hang }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="ri-close-line me-1"></i>{{ $sanpham->trang_thai_hang }}
                            </span>
                        @endif
                        <small class="text-muted ms-3">Còn {{ $sanpham->so_luong_ton_kho }} sản phẩm</small>
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="d-grid gap-2 d-md-flex">
                    <a href="{{ route('sanpham.edit', $sanpham->id) }}" class="btn btn-info">
                        <i class="ri-edit-line me-2"></i>Chỉnh sửa
                    </a>
                    <a href="{{ route('sanpham.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line me-2"></i>Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mô tả chi tiết -->
@if($sanpham->mo_ta || $sanpham->mo_ta_chi_tiet)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ri-file-text-line me-2"></i>Mô tả sản phẩm
                    </h5>
                </div>
                <div class="card-body">
                    @if($sanpham->mo_ta)
                        <div class="mb-3">
                            <h6>Mô tả ngắn:</h6>
                            <p>{{ $sanpham->mo_ta }}</p>
                        </div>
                    @endif
                    @if($sanpham->mo_ta_chi_tiet)
                        <div>
                            <h6>Mô tả chi tiết:</h6>
                            <div class="content">
                                {!! nl2br(e($sanpham->mo_ta_chi_tiet)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Sản phẩm liên quan -->
@if($sanphamLienQuan->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ri-links-line me-2"></i>Sản phẩm liên quan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($sanphamLienQuan as $sp)
                            <div class="col-lg-2 col-md-4 col-6">
                                <div class="card h-100">
                                    <div class="card-img-top" style="height: 150px; overflow: hidden;">
                                        @if($sp->hinh_anh)
                                            <img src="{{ asset($sp->hinh_anh) }}" 
                                                 class="w-100 h-100" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light h-100 d-flex align-items-center justify-content-center">
                                                <i class="ri-image-line text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="card-title small">{{ Str::limit($sp->ten, 30) }}</h6>
                                        <p class="card-text text-success small mb-1">
                                            <strong>{{ number_format($sp->gia) }} VNĐ</strong>
                                        </p>
                                        <a href="{{ route('sanpham.show', $sp->id) }}" 
                                           class="btn btn-primary btn-sm w-100">
                                            <i class="ri-eye-line me-1"></i>Xem
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
// Gallery image switching
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('main-image');
    const thumbs = document.querySelectorAll('.gallery-thumb');
    
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Update main image
            mainImage.src = this.src;
            
            // Update active state
            thumbs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>

<style>
.gallery-thumb {
    transition: all 0.3s ease;
}

.gallery-thumb:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.gallery-thumb.active {
    border-color: #0d6efd !important;
    border-width: 3px !important;
}

.content {
    line-height: 1.6;
}
</style>
@endsection
