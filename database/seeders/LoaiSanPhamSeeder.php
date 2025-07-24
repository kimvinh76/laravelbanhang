<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoaiSanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('loai_san_phams')->insert([
            ['ten_loai' => 'Điện thoại'],
            ['ten_loai' => 'Laptop'],
            ['ten_loai' => 'Phụ kiện'],
            ['ten_loai' => 'Thiết bị gia dụng'],
        ]);
    }
}