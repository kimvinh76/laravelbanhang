<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncToMySQLSeeder extends Seeder
{
    public function run()
    {
        // Lấy dữ liệu từ SQLite
        $categories = DB::connection('sqlite')->table('loai_san_phams')->get();
        $products = DB::connection('sqlite')->table('san_phams')->get();

        // Chèn dữ liệu vào MySQL
        foreach ($categories as $category) {
            DB::connection('mysql')->table('loai_san_phams')->insert((array) $category);
        }

        foreach ($products as $product) {
            DB::connection('mysql')->table('san_phams')->insert((array) $product);
        }
    }
}
