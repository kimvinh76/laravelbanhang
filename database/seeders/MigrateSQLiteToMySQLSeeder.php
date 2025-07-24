<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class MigrateSQLiteToMySQLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            // Thiết lập kết nối SQLite tạm thời
            Config::set('database.connections.sqlite_temp', [
                'driver' => 'sqlite',
                'database' => database_path('database.sqlite'),
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]);

            // Kiểm tra xem file SQLite có tồn tại không
            if (!file_exists(database_path('database.sqlite'))) {
                $this->command->info('File SQLite không tồn tại. Bỏ qua việc migrate dữ liệu.');
                return;
            }

            $this->command->info('Bắt đầu chuyển dữ liệu từ SQLite sang MySQL...');

            // Xóa dữ liệu cũ trong MySQL (nếu có)
            DB::connection('mysql')->table('san_phams')->delete();
            DB::connection('mysql')->table('loai_san_phams')->delete();

            // Lấy dữ liệu từ SQLite
            $categories = DB::connection('sqlite_temp')->table('loai_san_phams')->get();
            $products = DB::connection('sqlite_temp')->table('san_phams')->get();

            $this->command->info('Đã lấy ' . $categories->count() . ' danh mục và ' . $products->count() . ' sản phẩm từ SQLite');

            // Chuyển danh mục sản phẩm
            foreach ($categories as $category) {
                DB::connection('mysql')->table('loai_san_phams')->insert([
                    'id' => $category->id,
                    'ten_loai' => $category->ten_loai,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                ]);
            }

            // Chuyển sản phẩm
            foreach ($products as $product) {
                DB::connection('mysql')->table('san_phams')->insert([
                    'id' => $product->id,
                    'ten' => $product->ten,
                    'sku' => $product->sku,
                    'loai_san_pham_id' => $product->loai_san_pham_id,
                    'mo_ta' => $product->mo_ta,
                    'mo_ta_chi_tiet' => $product->mo_ta_chi_tiet,
                    'gia' => $product->gia,
                    'gia_goc' => $product->gia_goc,
                    'trong_luong' => $product->trong_luong,
                    'kich_thuoc' => $product->kich_thuoc,
                    'mau_sac' => $product->mau_sac,
                    'chat_lieu' => $product->chat_lieu,
                    'hang_san_xuat' => $product->hang_san_xuat,
                    'xuat_xu' => $product->xuat_xu,
                    'tinh_trang' => $product->tinh_trang,
                    'luot_xem' => $product->luot_xem,
                    'danh_gia_trung_binh' => $product->danh_gia_trung_binh,
                    'so_luong_danh_gia' => $product->so_luong_danh_gia,
                    'so_luong_ton_kho' => $product->so_luong_ton_kho,
                    'hinh_anh' => $product->hinh_anh,
                    'hinh_anh_bo_sung' => $product->hinh_anh_bo_sung,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ]);
            }

            $this->command->info('Đã chuyển thành công ' . $categories->count() . ' danh mục và ' . $products->count() . ' sản phẩm sang MySQL!');

        } catch (\Exception $e) {
            $this->command->error('Lỗi khi chuyển dữ liệu: ' . $e->getMessage());
        }
    }
}
