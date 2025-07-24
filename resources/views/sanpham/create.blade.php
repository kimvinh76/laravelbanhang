@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h3 class="card-title mb-0">
                    <i class="ri-add-circle-line me-2"></i>Thêm sản phẩm mới
                </h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="ri-error-warning-line me-1"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sanpham.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ten" class="form-label">
                                    <i class="ri-price-tag-3-line me-1"></i>Tên sản phẩm
                                </label>
                                <input type="text" class="form-control @error('ten') is-invalid @enderror" 
                                       id="ten" name="ten" value="{{ old('ten') }}" 
                                       placeholder="Nhập tên sản phẩm...">
                                @error('ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="loai_san_pham_id" class="form-label">
                                    <i class="ri-list-check me-1"></i>Loại sản phẩm
                                </label>
                                <select class="form-select @error('loai_san_pham_id') is-invalid @enderror" 
                                        id="loai_san_pham_id" name="loai_san_pham_id">
                                    <option value="">-- Chọn loại sản phẩm --</option>
                                    @foreach ($loaiSanPhams as $loai)
                                        <option value="{{ $loai->id }}" {{ old('loai_san_pham_id') == $loai->id ? 'selected' : '' }}>
                                            {{ $loai->ten_loai }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loai_san_pham_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gia" class="form-label">
                                    <i class="ri-money-dollar-circle-line me-1"></i>Giá (VNĐ)
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('gia') is-invalid @enderror" 
                                           id="gia" name="gia" value="{{ old('gia') }}" 
                                           placeholder="0" min="0" step="1000">
                                    <span class="input-group-text">VNĐ</span>
                                    @error('gia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hinh_anh" class="form-label">
                                    <i class="ri-image-line me-1"></i>Hình ảnh
                                </label>
                                <input type="file" class="form-control @error('hinh_anh') is-invalid @enderror" 
                                       id="hinh_anh" name="hinh_anh" accept="image/*">
                                @error('hinh_anh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Chỉ chấp nhận file ảnh (JPG, PNG, GIF)</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">
                            <i class="ri-file-text-line me-1"></i>Mô tả sản phẩm
                        </label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                  id="mo_ta" name="mo_ta" rows="4" 
                                  placeholder="Nhập mô tả chi tiết về sản phẩm...">{{ old('mo_ta') }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thông tin chi tiết bổ sung -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sku" class="form-label"><i class="ri-barcode-line me-1"></i>Mã sản phẩm (SKU)</label>
                                <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}" placeholder="SKU...">
                                @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="so_luong_ton_kho" class="form-label"><i class="ri-archive-line me-1"></i>Số lượng tồn kho</label>
                                <input type="number" class="form-control @error('so_luong_ton_kho') is-invalid @enderror" id="so_luong_ton_kho" name="so_luong_ton_kho" value="{{ old('so_luong_ton_kho', 0) }}" min="0">
                                @error('so_luong_ton_kho')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="trong_luong" class="form-label"><i class="ri-weight-line me-1"></i>Trọng lượng (kg)</label>
                                <input type="number" step="0.01" class="form-control @error('trong_luong') is-invalid @enderror" id="trong_luong" name="trong_luong" value="{{ old('trong_luong') }}">
                                @error('trong_luong')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="kich_thuoc" class="form-label"><i class="ri-ruler-2-line me-1"></i>Kích thước (DxRxC)</label>
                                <input type="text" class="form-control @error('kich_thuoc') is-invalid @enderror" id="kich_thuoc" name="kich_thuoc" value="{{ old('kich_thuoc') }}" placeholder="Dài x Rộng x Cao">
                                @error('kich_thuoc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mau_sac" class="form-label"><i class="ri-palette-line me-1"></i>Màu sắc</label>
                                <input type="text" class="form-control @error('mau_sac') is-invalid @enderror" id="mau_sac" name="mau_sac" value="{{ old('mau_sac') }}">
                                @error('mau_sac')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="chat_lieu" class="form-label"><i class="ri-shape-line me-1"></i>Chất liệu</label>
                                <input type="text" class="form-control @error('chat_lieu') is-invalid @enderror" id="chat_lieu" name="chat_lieu" value="{{ old('chat_lieu') }}">
                                @error('chat_lieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="hang_san_xuat" class="form-label"><i class="ri-building-2-line me-1"></i>Hãng sản xuất</label>
                                <input type="text" class="form-control @error('hang_san_xuat') is-invalid @enderror" id="hang_san_xuat" name="hang_san_xuat" value="{{ old('hang_san_xuat') }}">
                                @error('hang_san_xuat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="xuat_xu" class="form-label"><i class="ri-earth-line me-1"></i>Xuất xứ</label>
                                <input type="text" class="form-control @error('xuat_xu') is-invalid @enderror" id="xuat_xu" name="xuat_xu" value="{{ old('xuat_xu') }}">
                                @error('xuat_xu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gia_goc" class="form-label"><i class="ri-price-tag-2-line me-1"></i>Giá gốc (nếu có)</label>
                                <input type="number" class="form-control @error('gia_goc') is-invalid @enderror" id="gia_goc" name="gia_goc" value="{{ old('gia_goc') }}" min="0" step="1000">
                                @error('gia_goc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tinh_trang" class="form-label"><i class="ri-checkbox-circle-line me-1"></i>Tình trạng</label>
                                <select class="form-select @error('tinh_trang') is-invalid @enderror" id="tinh_trang" name="tinh_trang">
                                    <option value="1" {{ old('tinh_trang', 1) == 1 ? 'selected' : '' }}>Còn hàng</option>
                                    <option value="0" {{ old('tinh_trang') == 0 ? 'selected' : '' }}>Hết hàng</option>
                                </select>
                                @error('tinh_trang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="mo_ta_chi_tiet" class="form-label"><i class="ri-file-list-2-line me-1"></i>Mô tả chi tiết</label>
                        <textarea class="form-control @error('mo_ta_chi_tiet') is-invalid @enderror" id="mo_ta_chi_tiet" name="mo_ta_chi_tiet" rows="3" placeholder="Nhập mô tả chi tiết...">{{ old('mo_ta_chi_tiet') }}</textarea>
                        @error('mo_ta_chi_tiet')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="hinh_anh_bo_sung" class="form-label"><i class="ri-image-add-line me-1"></i>Hình ảnh bổ sung (có thể chọn nhiều)</label>
                        <input type="file" class="form-control @error('hinh_anh_bo_sung') is-invalid @enderror" id="hinh_anh_bo_sung" name="hinh_anh_bo_sung[]" accept="image/*" multiple>
                        @error('hinh_anh_bo_sung')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Có thể chọn nhiều ảnh bổ sung (JPG, PNG, GIF)</small>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('sanpham.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line me-1"></i>Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="ri-save-line me-1"></i>Lưu sản phẩm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview image khi chọn file
    document.getElementById('hinh_anh').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Tạo preview image nếu chưa có
                let preview = document.getElementById('image-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'image-preview';
                    preview.className = 'img-thumbnail mt-2';
                    preview.style.maxWidth = '200px';
                    preview.style.maxHeight = '200px';
                    document.getElementById('hinh_anh').parentNode.appendChild(preview);
                }
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
