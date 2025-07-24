<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Trang chủ website cho khách hàng
     */
    public function index()
    {
        // Sản phẩm nổi bật (có lượt xem cao)
        $sanPhamNoiBat = SanPham::with('loaiSanPham')
            ->where('tinh_trang', 1)
            ->orderBy('luot_xem', 'desc')
            ->limit(8)
            ->get();

        // Sản phẩm mới nhất
        $sanPhamMoi = SanPham::with('loaiSanPham')
            ->where('tinh_trang', 1)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Sản phẩm giảm giá
        $sanPhamGiamGia = SanPham::with('loaiSanPham')
            ->where('tinh_trang', 1)
            ->whereNotNull('gia_goc')
            ->whereColumn('gia_goc', '>', 'gia')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Danh mục sản phẩm
        $danhMuc = LoaiSanPham::withCount(['sanPhams' => function($query) {
            $query->where('tinh_trang', 1);
        }])->get();

        return view('customer.home', compact('sanPhamNoiBat', 'sanPhamMoi', 'sanPhamGiamGia', 'danhMuc'));
    }

    /**
     * Trang giới thiệu
     */
    public function about()
    {
        return view('customer.about');
    }

    /**
     * Trang liên hệ
     */
    public function contact()
    {
        return view('customer.contact');
    }

    /**
     * Xử lý form liên hệ
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Ở đây bạn có thể lưu vào database hoặc gửi email
        // Tạm thời chỉ thông báo thành công
        
        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
    }

    /**
     * Hiển thị trang danh sách danh mục
     */
    public function categories()
    {
        $categories = LoaiSanPham::withCount('sanphams')->get();
        $totalProducts = SanPham::where('tinh_trang', 1)->count();
        $popularCategories = LoaiSanPham::withCount('sanphams')
            ->orderBy('sanphams_count', 'desc')
            ->take(6)
            ->get();

        return view('customer.categories', compact('categories', 'totalProducts', 'popularCategories'));
    }
}
