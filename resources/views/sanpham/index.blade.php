@extends('layout')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4 text-center">
            <i class="ri-shopping-bag-3-line me-2"></i>Danh sách sản phẩm
        </h1>

        <!-- Form tìm kiếm -->
        <div class="card mb-4" data-ajax-search="true">
            <div class="card-body">
                <form id="search-form" action="{{ route('sanpham.index') }}" method="get">
                    <!-- Tìm kiếm cơ bản -->
                    <div class="row g-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-search-line"></i></span>
                                <input type="text" name="q" value="{{ request('q') }}" 
                                       class="form-control" placeholder="Tìm kiếm theo tên sản phẩm...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="loai_san_pham_id" class="form-select">
                                <option value="">-- Lọc theo loại sản phẩm --</option>
                                @foreach($loaiSanPhams as $loai)
                                    <option value="{{ $loai->id }}" {{ request('loai_san_pham_id') == $loai->id ? 'selected' : '' }}>
                                        {{ $loai->ten_loai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ri-search-line me-1"></i>Tìm kiếm
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="toggle-advanced-filter" class="btn btn-outline-secondary w-100">
                                <i class="ri-arrow-down-s-line"></i>
                                <span class="toggle-text">Bộ lọc nâng cao</span>
                            </button>
                        </div>
                    </div>

                    <!-- Bộ lọc nâng cao -->
                    <div id="advanced-filter-section" style="display: none;" class="mt-3 pt-3 border-top">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="ri-money-dollar-circle-line me-1"></i>Khoảng giá
                                </label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Từ</span>
                                            <input type="number" name="min_price" id="min_price" 
                                                   class="form-control" placeholder="0" 
                                                   value="{{ request('min_price') }}" 
                                                   min="0" step="10000">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Đến</span>
                                            <input type="number" name="max_price" id="max_price" 
                                                   class="form-control" placeholder="10000000" 
                                                   value="{{ request('max_price') }}" 
                                                   min="0" step="10000">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    Hiện tại: <span id="price-range-display">Tất cả giá</span>
                                </small>
                                @if(isset($priceRange))
                                    <br>
                                    <small class="text-muted">
                                        Giá sản phẩm: {{ number_format($priceRange->min_price ?? 0) }} - {{ number_format($priceRange->max_price ?? 0) }} VNĐ
                                    </small>
                                @endif
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="btn-group w-100" role="group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="ri-filter-line me-1"></i>Áp dụng bộ lọc
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetAllFilters()">
                                        <i class="ri-refresh-line me-1"></i>Đặt lại
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nút đặt lại cơ bản -->
                    <div class="mt-2">
                        <a href="{{ route('sanpham.index') }}" class="btn btn-secondary btn-sm">
                            <i class="ri-refresh-line me-1"></i>Đặt lại tất cả
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Thông tin tổng quan -->
        <div class="row mb-3">
            <div class="col-md-8">
                <p class="text-muted mb-0">
                    <i class="ri-information-line me-1"></i>
                    Hiển thị {{ $sanphams->firstItem() ?? 0 }} đến {{ $sanphams->lastItem() ?? 0 }} 
                    của {{ $sanphams->total() }} sản phẩm
                    @if(request('q'))
                        <span class="badge bg-warning text-dark ms-2">
                            <i class="ri-search-line me-1"></i>Tìm kiếm: "{{ request('q') }}"
                        </span>
                    @endif
                    @if(request('loai_san_pham_id'))
                        @php
                            $selectedLoai = $loaiSanPhams->find(request('loai_san_pham_id'));
                        @endphp
                        @if($selectedLoai)
                            <span class="badge bg-info ms-2">
                                <i class="ri-filter-line me-1"></i>Loại: {{ $selectedLoai->ten_loai }}
                            </span>
                        @endif
                    @endif
                    @if(request('min_price') || request('max_price'))
                        <span class="badge bg-success ms-2">
                            <i class="ri-money-dollar-circle-line me-1"></i>
                            Giá: {{ request('min_price') ? number_format(request('min_price')) : '0' }} - 
                            {{ request('max_price') ? number_format(request('max_price')) : '∞' }} VNĐ
                        </span>
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-end">
                <small class="text-muted">
                    <i class="ri-sort-desc me-1"></i>Sắp xếp: Mới nhất trên đầu
                </small>
                <br>
                @if($sanphams->hasPages())
                    <small class="text-muted">
                        <i class="ri-pages-line me-1"></i>Trang {{ $sanphams->currentPage() }} / {{ $sanphams->lastPage() }}
                    </small>
                @else
                    <small class="text-muted">
                        <i class="ri-file-list-3-line me-1"></i>Hiển thị tất cả
                    </small>
                @endif
                <br>
                <small class="text-muted">
                    <i class="ri-settings-line me-1"></i>{{ $sanphams->perPage() }} sản phẩm/trang
                </small>
            </div>
        </div>

        <!-- Nút thêm sản phẩm và tùy chọn hiển thị -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <label for="per_page" class="form-label me-2 mb-0">Hiển thị:</label>
                    <select id="per_page" class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <span class="text-muted ms-2">sản phẩm/trang</span>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('sanpham.create') }}" class="btn btn-success btn-lg">
                    <i class="ri-add-circle-line me-2"></i>Thêm sản phẩm mới
                </a>
            </div>
        </div>

        <!-- Bảng sản phẩm -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>STT <i class="ri-arrow-up-line text-warning" title="Thứ tự hiển thị"></i></th>
                                <th>Tên sản phẩm</th>
                                <th>Loại sản phẩm</th>
                                <th>Giá</th>
                                <th>Hình ảnh</th>
                               <th>SKU</th>
                               <th>Tồn kho</th>
                               <th>Tình trạng</th>
                               <th>Hãng</th>
                               <th>Xuất xứ</th>
                               <th>Màu sắc</th>
                               <th>Giá gốc</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sanphams as $index => $sp)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ ($sanphams->currentPage() - 1) * $sanphams->perPage() + $index + 1 }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $sp->ten }}</strong></td>
                                    <td>
                                        <span class="badge bg-info">{{ $sp->loaiSanPham->ten_loai ?? 'Chưa phân loại' }}</span>
                                    </td>
                                    <td><strong class="text-success">{{ number_format($sp->gia) }} VNĐ</strong></td>
                                    <td>
                                        @if($sp->hinh_anh)
                                            <img src="{{ asset($sp->hinh_anh) }}" width="60" height="60" 
                                                 class="rounded" style="object-fit: cover;">
                                        @else
                                            <span class="text-muted">Chưa có hình</span>
                                        @endif
                                    </td>
                                   <td>{{ $sp->sku }}</td>
                                   <td>{{ $sp->so_luong_ton_kho }}</td>
                                   <td>
                                       @if($sp->tinh_trang)
                                           <span class="badge bg-success">Còn hàng</span>
                                       @else
                                           <span class="badge bg-danger">Hết hàng</span>
                                       @endif
                                   </td>
                                   <td>{{ $sp->hang_san_xuat }}</td>
                                   <td>{{ $sp->xuat_xu }}</td>
                                   <td>{{ $sp->mau_sac }}</td>
                                   <td>
                                       @if($sp->gia_goc && $sp->gia_goc > $sp->gia)
                                           <span class="text-decoration-line-through text-muted">{{ number_format($sp->gia_goc) }} VNĐ</span>
                                       @endif
                                   </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('sanpham.show', $sp->id) }}" 
                                               class="btn btn-primary btn-sm" title="Xem chi tiết">
                                                <i class="ri-eye-line"></i> Chi tiết
                                            </a>
                                            <a href="{{ route('sanpham.edit', $sp->id) }}" 
                                               class="btn btn-info btn-sm" title="Chỉnh sửa">
                                                <i class="ri-edit-line"></i> Sửa
                                            </a>
                                            <form action="{{ route('sanpham.destroy', $sp->id) }}" method="POST" 
                                                  style="display:inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Xóa sản phẩm">
                                                    <i class="ri-delete-bin-line"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($sanphams->isEmpty())
                    <div class="text-center py-5">
                        <i class="ri-inbox-line" style="font-size: 4rem; color: #6c757d;"></i>
                        <h4 class="text-muted mt-3">Không có sản phẩm nào</h4>
                        <p class="text-muted">Hãy thêm sản phẩm đầu tiên của bạn!</p>
                        <a href="{{ route('sanpham.create') }}" class="btn btn-success">
                            <i class="ri-add-circle-line me-2"></i>Thêm sản phẩm
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Phân trang và thông tin -->
        <div class="row mt-4">
            <div class="col-md-6 d-flex align-items-center">
                <span class="text-muted">
                    <i class="ri-file-list-line me-1"></i>
                    @if($sanphams->total() > 0)
                        Hiển thị {{ $sanphams->firstItem() }} - {{ $sanphams->lastItem() }} 
                        trong tổng số {{ $sanphams->total() }} sản phẩm
                    @else
                        Không có sản phẩm nào
                    @endif
                </span>
            </div>
            <div class="col-md-6">
                @if($sanphams->total() > 0)
                    @if($sanphams->hasPages())
                        <div class="d-flex justify-content-end">
                            {{ $sanphams->appends(request()->input())->links('pagination::custom') }}
                        </div>
                    @else
                        <div class="text-end">
                            <span class="text-muted">
                                <i class="ri-pages-line me-1"></i>
                                Tất cả {{ $sanphams->total() }} sản phẩm trong 1 trang
                            </span>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function changePerPage(perPage) {
    if (window.SanPhamFilter) {
        const filter = new window.SanPhamFilter();
        filter.changePerPage(perPage);
    } else {
        // Fallback nếu class chưa load
        const url = new URL(window.location);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
}

function resetAllFilters() {
    if (window.SanPhamFilter) {
        const filter = new window.SanPhamFilter();
        filter.resetAllFilters();
    } else {
        // Fallback nếu class chưa load
        window.location.href = '{{ route("sanpham.index") }}';
    }
}
</script>
@endsection
