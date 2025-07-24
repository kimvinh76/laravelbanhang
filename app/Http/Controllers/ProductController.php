<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Danh sách sản phẩm cho khách hàng
     */
    public function index(Request $request)
    {
        $query = SanPham::with('loaiSanPham')->where('tinh_trang', 1);
        $loaiSanPhams = LoaiSanPham::all();

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where('ten', 'like', '%' . $request->get('search') . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('loai_san_pham_id', $request->get('category'));
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->where('gia', '>=', $request->get('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('gia', '<=', $request->get('max_price'));
        }

        // Lọc theo hãng
        if ($request->filled('brand')) {
            $query->where('hang_san_xuat', $request->get('brand'));
        }

        // Sắp xếp
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('gia', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('gia', 'desc');
                break;
            case 'name':
                $query->orderBy('ten', 'asc');
                break;
            case 'popular':
                $query->orderBy('luot_xem', 'desc');
                break;
            case 'sale':
                $query->whereColumn('gia', '<', 'gia_goc')
                      ->orderByRaw('(gia_goc - gia) DESC');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 12);
        $sanphams = $query->paginate($perPage);

        // Lấy các hãng có sẵn
        $brands = SanPham::where('tinh_trang', 1)
            ->whereNotNull('hang_san_xuat')
            ->distinct()
            ->pluck('hang_san_xuat');

        // Giá min/max
        $priceRange = SanPham::where('tinh_trang', 1)
            ->selectRaw('MIN(gia) as min_price, MAX(gia) as max_price')
            ->first();

        return view('customer.products.index', compact(
            'sanphams', 'loaiSanPhams', 'brands', 'priceRange'
        ));
    }

    /**
     * Chi tiết sản phẩm cho khách hàng
     */
    public function show($id)
    {
        $sanpham = SanPham::with('loaiSanPham')
            ->where('tinh_trang', 1)
            ->findOrFail($id);

        // Tăng lượt xem
        $sanpham->increment('luot_xem');

        // Sản phẩm liên quan
        $sanphamLienQuan = SanPham::with('loaiSanPham')
            ->where('loai_san_pham_id', $sanpham->getAttribute('loai_san_pham_id'))
            ->where('id', '!=', $id)
            ->where('tinh_trang', 1)
            ->limit(8)
            ->get();

        // Sản phẩm cùng hãng
        $sanphamCungHang = [];
        if ($sanpham->getAttribute('hang_san_xuat')) {
            $sanphamCungHang = SanPham::with('loaiSanPham')
                ->where('hang_san_xuat', $sanpham->getAttribute('hang_san_xuat'))
                ->where('id', '!=', $id)
                ->where('tinh_trang', 1)
                ->limit(4)
                ->get();
        }

        return view('customer.products.show', compact(
            'sanpham', 'sanphamLienQuan', 'sanphamCungHang'
        ));
    }

    /**
     * Hiển thị sản phẩm theo danh mục
     */
    public function category($id)
    {
        $category = LoaiSanPham::findOrFail($id);
        
        $query = SanPham::with('loaiSanPham')
            ->where('loai_san_pham_id', $id)
            ->where('tinh_trang', 1);

        // Filter by price range
        if (request('min_price')) {
            $query->where('gia', '>=', request('min_price'));
        }
        if (request('max_price')) {
            $query->where('gia', '<=', request('max_price'));
        }

        // Filter by brands
        if (request('brands')) {
            $query->whereIn('hang_san_xuat', request('brands'));
        }

        // Filter by colors
        if (request('colors')) {
            $query->whereIn('mau_sac', request('colors'));
        }

        // Filter by materials
        if (request('materials')) {
            $query->whereIn('chat_lieu', request('materials'));
        }

        // Filter by stock status
        if (request('in_stock')) {
            $query->where('so_luong_ton_kho', '>', 0);
        }

        // Filter by sale status
        if (request('on_sale')) {
            $query->whereColumn('gia', '<', 'gia_goc');
        }

        // Sort
        switch (request('sort')) {
            case 'price_asc':
                $query->orderBy('gia', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('gia', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('ten', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('ten', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('luot_xem', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        // Get filter options for sidebar
        $baseQuery = SanPham::where('loai_san_pham_id', $id)->where('tinh_trang', 1);
        
        $brands = $baseQuery->whereNotNull('hang_san_xuat')
            ->distinct()
            ->pluck('hang_san_xuat')
            ->filter();

        $colors = $baseQuery->whereNotNull('mau_sac')
            ->distinct()
            ->pluck('mau_sac')
            ->filter();

        $materials = $baseQuery->whereNotNull('chat_lieu')
            ->distinct()
            ->pluck('chat_lieu')
            ->filter();

        return view('customer.products.category', compact(
            'category', 'products', 'brands', 'colors', 'materials'
        ));
    }

    /**
     * Tìm kiếm AJAX
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = SanPham::where('tinh_trang', 1)
            ->where('ten', 'like', '%' . $query . '%')
            ->limit(10)
            ->get(['id', 'ten', 'gia', 'hinh_anh']);

        return response()->json($results);
    }
}
