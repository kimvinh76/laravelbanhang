<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SanPham extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ten', 'sku', 'mo_ta', 'mo_ta_chi_tiet', 'gia', 'gia_goc', 'hinh_anh', 'hinh_anh_bo_sung',
        'loai_san_pham_id', 'so_luong_ton_kho', 'trong_luong', 'kich_thuoc', 'mau_sac', 
        'chat_lieu', 'hang_san_xuat', 'xuat_xu', 'tinh_trang', 'luot_xem', 
        'danh_gia_trung_binh', 'so_luong_danh_gia'
    ];

    protected $casts = [
        'hinh_anh_bo_sung' => 'array',
        'gia' => 'decimal:2',
        'gia_goc' => 'decimal:2',
        'trong_luong' => 'decimal:2',
        'danh_gia_trung_binh' => 'decimal:2',
        'tinh_trang' => 'boolean'
    ];

    public function loaiSanPham()
    {
        return $this->belongsTo(LoaiSanPham::class, 'loai_san_pham_id', 'id');
    }

    // Accessor cho phần trăm giảm giá
    public function getPhanTramGiamGiaAttribute()
    {
        if ($this->gia_goc && $this->gia_goc > $this->gia) {
            return round((($this->gia_goc - $this->gia) / $this->gia_goc) * 100);
        }
        return 0;
    }

    // Accessor cho trạng thái còn hàng
    public function getTrangThaiHangAttribute()
    {
        if ($this->so_luong_ton_kho <= 0) return 'Hết hàng';
        if ($this->so_luong_ton_kho <= 5) return 'Sắp hết hàng';
        return 'Còn hàng';
    }

    // Scope cho sản phẩm còn hàng
    public function scopeConHang($query)
    {
        return $query->where('tinh_trang', true)->where('so_luong_ton_kho', '>', 0);
    }

    // Tăng lượt xem
    public function tangLuotXem()
    {
        $this->increment('luot_xem');
    }
}


