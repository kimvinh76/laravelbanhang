<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('san_phams', function (Blueprint $table) {
            // Thông tin chi tiết sản phẩm
            $table->text('mo_ta_chi_tiet')->nullable()->after('mo_ta');
            $table->json('hinh_anh_bo_sung')->nullable()->after('hinh_anh'); // Nhiều ảnh
            $table->integer('so_luong_ton_kho')->default(0)->after('gia');
            $table->string('sku')->unique()->nullable()->after('ten'); // Mã sản phẩm
            $table->decimal('trong_luong', 8, 2)->nullable()->after('gia'); // kg
            $table->string('kich_thuoc')->nullable()->after('trong_luong'); // DxRxC
            $table->string('mau_sac')->nullable()->after('kich_thuoc');
            $table->string('chat_lieu')->nullable()->after('mau_sac');
            $table->string('hang_san_xuat')->nullable()->after('chat_lieu');
            $table->string('xuat_xu')->nullable()->after('hang_san_xuat');
            $table->boolean('tinh_trang')->default(1)->after('xuat_xu'); // 1: còn hàng, 0: hết hàng
            $table->decimal('gia_goc', 10, 2)->nullable()->after('gia'); // Giá gốc để tính % giảm
            $table->integer('luot_xem')->default(0)->after('tinh_trang');
            $table->decimal('danh_gia_trung_binh', 3, 2)->default(0)->after('luot_xem'); // 0-5 sao
            $table->integer('so_luong_danh_gia')->default(0)->after('danh_gia_trung_binh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('san_phams', function (Blueprint $table) {
            $table->dropColumn([
                'mo_ta_chi_tiet',
                'hinh_anh_bo_sung',
                'so_luong_ton_kho',
                'sku',
                'trong_luong',
                'kich_thuoc',
                'mau_sac',
                'chat_lieu',
                'hang_san_xuat',
                'xuat_xu',
                'tinh_trang',
                'gia_goc',
                'luot_xem',
                'danh_gia_trung_binh',
                'so_luong_danh_gia'
            ]);
        });
    }
};
