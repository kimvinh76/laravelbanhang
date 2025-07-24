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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Bắt buộc để dùng foreign key

            $table->id();
            $table->string('ten');
            $table->unsignedBigInteger('loai_san_pham_id')->nullable();
            $table->foreign('loai_san_pham_id')
                  ->references('id')
                  ->on('loai_san_phams')
                  ->onDelete('set null');
            $table->text('mo_ta')->nullable();
            $table->decimal('gia', 12, 2);
            $table->string('hinh_anh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
