<?php



namespace App\Http\Controllers;

use App\Models\LoaiSanPham;
use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {
        $query = SanPham::with('loaiSanPham'); // Eager load để tối ưu
        $loaiSanPhams = LoaiSanPham::all();

        // Tìm kiếm theo tên
        if ($request->has('q') && $request->q != '') {
            $query->where('ten', 'like', '%' . $request->q . '%');
        }

        // Lọc theo loại sản phẩm
        if ($request->filled('loai_san_pham_id')) {
            $query->where('loai_san_pham_id', $request->loai_san_pham_id);
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->where('gia', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('gia', '<=', $request->max_price);
        }

        // Lấy số lượng sản phẩm trên mỗi trang từ request (mặc định 10)
        $perPage = $request->get('per_page', 10);
        // Đảm bảo giá trị hợp lệ
        $perPage = in_array($perPage, [5, 10, 20, 50]) ? $perPage : 10;

        // Sắp xếp theo ID giảm dần (mới nhất lên trên) và created_at để đảm bảo
        $sanphams = $query->orderBy('id', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate($perPage);

        // Lấy giá min/max để hiển thị range
        $priceRange = SanPham::selectRaw('MIN(gia) as min_price, MAX(gia) as max_price')->first();

        // Nếu là AJAX request, trả về JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('sanpham.partials.table', compact('sanphams'))->render(),
                'pagination' => $sanphams->appends($request->input())->links('pagination::custom')->render(),
                'info' => view('sanpham.partials.info', compact('sanphams', 'loaiSanPhams'))->render(),
                'total' => $sanphams->total(),
                'current_page' => $sanphams->currentPage(),
                'last_page' => $sanphams->lastPage()
            ]);
        }

        return view('sanpham.index', compact('sanphams', 'loaiSanPhams', 'priceRange'))->with([
            'error' => session('error')
        ]);

        // Catch block removed to handle errors more gracefully with user feedback
        // Database errors should be handled by a global error handler in production
    }

    public function create()
    {
        $loaiSanPhams = LoaiSanPham::all();
        return view('sanpham.create', compact('loaiSanPhams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'loai_san_pham_id' => 'nullable|exists:loai_san_phams,id',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sku' => 'nullable|string|max:255|unique:san_phams,sku',
            'so_luong_ton_kho' => 'nullable|integer|min:0',
            'trong_luong' => 'nullable|numeric|min:0',
            'kich_thuoc' => 'nullable|string|max:255',
            'mau_sac' => 'nullable|string|max:255',
            'chat_lieu' => 'nullable|string|max:255',
            'hang_san_xuat' => 'nullable|string|max:255',
            'xuat_xu' => 'nullable|string|max:255',
            'tinh_trang' => 'nullable|boolean',
            'gia_goc' => 'nullable|numeric|min:0',
            'mo_ta_chi_tiet' => 'nullable|string',
            'hinh_anh_bo_sung.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'loai_san_pham_id.exists' => 'Loại sản phẩm không hợp lệ.'
        ]);

        $data = $request->only([
            'ten', 'mo_ta', 'gia', 'loai_san_pham_id', 'sku', 'so_luong_ton_kho', 'trong_luong',
            'kich_thuoc', 'mau_sac', 'chat_lieu', 'hang_san_xuat', 'xuat_xu', 'tinh_trang',
            'gia_goc', 'mo_ta_chi_tiet'
        ]);

        // Xử lý hình ảnh chính
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['hinh_anh'] = 'images/' . $filename;
        }

        // Xử lý nhiều hình ảnh bổ sung
        $hinhAnhBoSung = [];
        if ($request->hasFile('hinh_anh_bo_sung')) {
            foreach ($request->file('hinh_anh_bo_sung') as $file) {
                if ($file) {
                    $filename = time().'_'.uniqid().'_'.$file->getClientOriginalName();
                    $file->move(public_path('images'), $filename);
                    $hinhAnhBoSung[] = 'images/' . $filename;
                }
            }
        }
        $data['hinh_anh_bo_sung'] = $hinhAnhBoSung;

        SanPham::create($data);

        return redirect()->route('sanpham.index')->with('success', 'Thêm sản phẩm thành công!');
    }
    
    public function show($id)
    {
        $sanpham = SanPham::with('loaiSanPham')->findOrFail($id);
        
        // Tăng lượt xem
        $sanpham->tangLuotXem();
        
        // Sản phẩm liên quan (cùng loại, khác ID)
        $sanphamLienQuan = SanPham::with('loaiSanPham')
            ->where('loai_san_pham_id', $sanpham->loai_san_pham_id)
            ->where('id', '!=', $id)
            ->conHang()
            ->limit(6)
            ->get();
        
        return view('sanpham.show', compact('sanpham', 'sanphamLienQuan'));
    }

    public function edit($id)
    {
        $sanpham = SanPham::findOrFail($id);
        $loaiSanPhams = LoaiSanPham::all();
        return view('sanpham.edit', compact('sanpham', 'loaiSanPhams'));
    }

    public function update(Request $request, $id)
    {
        $sanpham = SanPham::findOrFail($id);

        $request->validate([
            'ten' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'loai_san_pham_id' => 'nullable|exists:loai_san_phams,id',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sku' => 'nullable|string|max:255|unique:san_phams,sku,'.$id,
            'so_luong_ton_kho' => 'nullable|integer|min:0',
            'trong_luong' => 'nullable|numeric|min:0',
            'kich_thuoc' => 'nullable|string|max:255',
            'mau_sac' => 'nullable|string|max:255',
            'chat_lieu' => 'nullable|string|max:255',
            'hang_san_xuat' => 'nullable|string|max:255',
            'xuat_xu' => 'nullable|string|max:255',
            'tinh_trang' => 'nullable|boolean',
            'gia_goc' => 'nullable|numeric|min:0',
            'mo_ta_chi_tiet' => 'nullable|string',
            'hinh_anh_bo_sung.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'loai_san_pham_id.exists' => 'Loại sản phẩm không hợp lệ.'
        ]);

        $data = $request->only([
            'ten', 'mo_ta', 'gia', 'loai_san_pham_id', 'sku', 'so_luong_ton_kho', 'trong_luong',
            'kich_thuoc', 'mau_sac', 'chat_lieu', 'hang_san_xuat', 'xuat_xu', 'tinh_trang',
            'gia_goc', 'mo_ta_chi_tiet'
        ]);

        // Xử lý hình ảnh chính
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['hinh_anh'] = 'images/' . $filename;
        }

        // Xử lý nhiều hình ảnh bổ sung
        $hinhAnhBoSung = $sanpham->hinh_anh_bo_sung ?? [];
        if ($request->hasFile('hinh_anh_bo_sung')) {
            foreach ($request->file('hinh_anh_bo_sung') as $file) {
                if ($file) {
                    $filename = time().'_'.uniqid().'_'.$file->getClientOriginalName();
                    $file->move(public_path('images'), $filename);
                    $hinhAnhBoSung[] = 'images/' . $filename;
                }
            }
        }
        $data['hinh_anh_bo_sung'] = $hinhAnhBoSung;

        $sanpham->update($data);

        return redirect()->route('sanpham.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $sanpham = SanPham::findOrFail($id);
        $sanpham->delete();

        return redirect()->route('sanpham.index')->with('success', 'Xoá sản phẩm thành công!');
    }

     public function missingMethod($parameters = [])
    {
        // Handle any attempted GET request to /sanpham
        return redirect()->route('sanpham.create');
    }
}
