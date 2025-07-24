<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SanPham;
use App\Models\LoaiSanPham;

class SanPhamSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        SanPham::truncate();
        
        $products = [
            [
                'ten' => 'iPhone 15 Pro Max 256GB',
                'gia' => 34990000,
                'gia_goc' => 39990000,
                'mo_ta' => 'iPhone 15 Pro Max với chip A17 Pro mạnh mẽ, camera 48MP tiên tiến',
                'mo_ta_chi_tiet' => 'iPhone 15 Pro Max được trang bị chip A17 Pro 3nm tiên tiến nhất, camera chính 48MP với khả năng zoom quang học 5x, pin sử dụng cả ngày, thiết kế titan cao cấp. Màn hình Super Retina XDR 6.7 inch với ProMotion, hỗ trợ Always-On display.',
                'hinh_anh' => '/picture/anh1.jpg',
                'loai_san_pham_id' => 1,
                'hang_san_xuat' => 'Apple',
                'xuat_xu' => 'Mỹ',
                'mau_sac' => 'Titan Tự Nhiên',
                'chat_lieu' => 'Titan',
                'trong_luong' => 0.221,
                'kich_thuoc' => '159.9 x 76.7 x 8.25 mm',
                'so_luong_ton_kho' => 50,
                'sku' => 'IP15PM-256-TN',
                'tinh_trang' => 1,
                'luot_xem' => 1500,
                'danh_gia_trung_binh' => 4.8,
                'so_luong_danh_gia' => 125
            ],
            [
                'ten' => 'Samsung Galaxy S24 Ultra 512GB',
                'gia' => 29990000,
                'gia_goc' => 33990000,
                'mo_ta' => 'Galaxy S24 Ultra với S Pen tích hợp, camera 200MP, AI tiên tiến',
                'mo_ta_chi_tiet' => 'Samsung Galaxy S24 Ultra mang đến trải nghiệm cao cấp với camera 200MP, S Pen tích hợp, màn hình Dynamic AMOLED 2X 6.8 inch, chip Snapdragon 8 Gen 3 for Galaxy. Hỗ trợ Galaxy AI với các tính năng thông minh.',
                'hinh_anh' => '/picture/anh2.jpg',
                'loai_san_pham_id' => 1,
                'hang_san_xuat' => 'Samsung',
                'xuat_xu' => 'Hàn Quốc',
                'mau_sac' => 'Đen Titan',
                'chat_lieu' => 'Nhôm + Thủy tinh',
                'trong_luong' => 0.232,
                'kich_thuoc' => '162.3 x 79.0 x 8.6 mm',
                'so_luong_ton_kho' => 30,
                'sku' => 'SGS24U-512-BT',
                'tinh_trang' => 1,
                'luot_xem' => 1200,
                'danh_gia_trung_binh' => 4.7,
                'so_luong_danh_gia' => 89
            ],
            [
                'ten' => 'MacBook Pro 16 inch M3 Pro 512GB',
                'gia' => 67990000,
                'gia_goc' => 74990000,
                'mo_ta' => 'MacBook Pro 16 inch với chip M3 Pro, hiệu năng vượt trội cho professional',
                'mo_ta_chi_tiet' => 'MacBook Pro 16 inch với chip M3 Pro 12-core CPU, 18-core GPU, 512GB SSD, màn hình Liquid Retina XDR 16.2 inch, pin 22 giờ. Thiết kế đẳng cấp cho các chuyên gia sáng tạo.',
                'hinh_anh' => '/picture/anh3.jpg',
                'loai_san_pham_id' => 2,
                'hang_san_xuat' => 'Apple',
                'xuat_xu' => 'Mỹ',
                'mau_sac' => 'Xám Không Gian',
                'chat_lieu' => 'Nhôm',
                'trong_luong' => 2.16,
                'kich_thuoc' => '355.7 x 248.1 x 16.8 mm',
                'so_luong_ton_kho' => 15,
                'sku' => 'MBP16-M3P-512-SG',
                'tinh_trang' => 1,
                'luot_xem' => 800,
                'danh_gia_trung_binh' => 4.9,
                'so_luong_danh_gia' => 67
            ],
            [
                'ten' => 'iPad Pro 12.9 inch M2 256GB',
                'gia' => 28990000,
                'gia_goc' => 32990000,
                'mo_ta' => 'iPad Pro với chip M2, màn hình Liquid Retina XDR, hỗ trợ Apple Pencil',
                'mo_ta_chi_tiet' => 'iPad Pro 12.9 inch với chip M2 8-core CPU, 10-core GPU, màn hình Liquid Retina XDR 12.9 inch với công nghệ miniLED. Hỗ trợ Apple Pencil Gen 2, Magic Keyboard.',
                'hinh_anh' => '/picture/anh4.png',
                'loai_san_pham_id' => 3,
                'hang_san_xuat' => 'Apple',
                'xuat_xu' => 'Mỹ',
                'mau_sac' => 'Bạc',
                'chat_lieu' => 'Nhôm',
                'trong_luong' => 0.682,
                'kich_thuoc' => '280.6 x 214.9 x 6.4 mm',
                'so_luong_ton_kho' => 25,
                'sku' => 'IPADPRO-M2-256-SL',
                'tinh_trang' => 1,
                'luot_xem' => 600,
                'danh_gia_trung_binh' => 4.6,
                'so_luong_danh_gia' => 43
            ],
            [
                'ten' => 'AirPods Pro Gen 2 USB-C',
                'gia' => 6490000,
                'gia_goc' => 7490000,
                'mo_ta' => 'AirPods Pro thế hệ 2 với chip H2, chống ồn chủ động nâng cao',
                'mo_ta_chi_tiet' => 'AirPods Pro Gen 2 với chip H2 mới, chống ồn chủ động gấp 2 lần, âm thanh không gian cá nhân hóa, pin 30 giờ với case sạc.',
                'hinh_anh' => '/picture/anh5.webp',
                'loai_san_pham_id' => 3,
                'hang_san_xuat' => 'Apple',
                'xuat_xu' => 'Mỹ',
                'mau_sac' => 'Trắng',
                'chat_lieu' => 'Nhựa',
                'trong_luong' => 0.056,
                'kich_thuoc' => '21.8 x 24.0 x 30.9 mm',
                'so_luong_ton_kho' => 100,
                'sku' => 'APP2-USBC-WH',
                'tinh_trang' => 1,
                'luot_xem' => 900,
                'danh_gia_trung_binh' => 4.8,
                'so_luong_danh_gia' => 156
            ],
            [
                'ten' => 'Sony WH-1000XM5 Wireless',
                'gia' => 8990000,
                'gia_goc' => 9990000,
                'mo_ta' => 'Tai nghe chống ồn cao cấp Sony với âm thanh Hi-Res',
                'mo_ta_chi_tiet' => 'Sony WH-1000XM5 với công nghệ chống ồn hàng đầu, driver 30mm, pin 30 giờ, sạc nhanh, hỗ trợ LDAC và Hi-Res Audio.',
                'hinh_anh' => '/picture/anh6.jpg',
                'loai_san_pham_id' => 3,
                'hang_san_xuat' => 'Sony',
                'xuat_xu' => 'Nhật Bản',
                'mau_sac' => 'Đen',
                'chat_lieu' => 'Nhựa + Da',
                'trong_luong' => 0.250,
                'kich_thuoc' => '254 x 220 x 32 mm',
                'so_luong_ton_kho' => 35,
                'sku' => 'SONY-WH1000XM5-BK',
                'tinh_trang' => 1,
                'luot_xem' => 450,
                'danh_gia_trung_binh' => 4.7,
                'so_luong_danh_gia' => 78
            ],
            [
                'ten' => 'Áo Polo Nam Uniqlo',
                'gia' => 590000,
                'gia_goc' => 790000,
                'mo_ta' => 'Áo polo nam chất liệu cotton cao cấp, form dáng Regular Fit',
                'mo_ta_chi_tiet' => 'Áo polo nam Uniqlo chất liệu 100% cotton, thiết kế cổ điển, form Regular Fit thoải mái, có nhiều màu sắc để lựa chọn.',
                'hinh_anh' => '/picture/anh7.jpg',
                'loai_san_pham_id' => 4,
                'hang_san_xuat' => 'Uniqlo',
                'xuat_xu' => 'Việt Nam',
                'mau_sac' => 'Xanh Navy',
                'chat_lieu' => '100% Cotton',
                'trong_luong' => 0.250,
                'kich_thuoc' => 'Size M',
                'so_luong_ton_kho' => 200,
                'sku' => 'UNIQ-POLO-M-NV',
                'tinh_trang' => 1,
                'luot_xem' => 320,
                'danh_gia_trung_binh' => 4.4,
                'so_luong_danh_gia' => 234
            ],
            [
                'ten' => 'Giày Nike Air Force 1',
                'gia' => 2890000,
                'gia_goc' => 3290000,
                'mo_ta' => 'Giày sneaker Nike Air Force 1 cổ điển, phù hợp mọi phong cách',
                'mo_ta_chi_tiet' => 'Nike Air Force 1 với thiết kế cổ điển, đế Air-Sole êm ái, chất liệu da cao cấp, phù hợp cho cả nam và nữ.',
                'hinh_anh' => '/picture/anh8.jpg',
                'loai_san_pham_id' => 4,
                'hang_san_xuat' => 'Nike',
                'xuat_xu' => 'Việt Nam',
                'mau_sac' => 'Trắng',
                'chat_lieu' => 'Da + Cao su',
                'trong_luong' => 0.850,
                'kich_thuoc' => 'Size 42',
                'so_luong_ton_kho' => 80,
                'sku' => 'NIKE-AF1-42-WH',
                'tinh_trang' => 1,
                'luot_xem' => 670,
                'danh_gia_trung_binh' => 4.6,
                'so_luong_danh_gia' => 189
            ]
        ];

        foreach ($products as $product) {
            SanPham::create($product);
        }

        $this->command->info('Đã tạo ' . count($products) . ' sản phẩm mẫu!');
    }
}
