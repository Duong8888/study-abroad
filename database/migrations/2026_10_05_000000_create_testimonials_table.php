<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('content');
            $table->longText('avatar')->nullable();
            $table->timestamps();
        });

        // Dữ liệu cảm nhận đang hiển thị sẵn trên trang chủ
        $now = now();
        DB::table('testimonials')->insert([
            [
                'name' => 'Ánh Dương',
                'content' => 'Cảm nhận của em về trung tâm SMARTEDU là có chương trình du học rõ ràng về học phí, phí Visa, hỗ trợ học sinh cả bên Việt Nam và Hàn Quốc (gồm cả Lên chuyên ngành và chuyển trường)',
                'avatar' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'An',
                'content' => 'Mục tiêu của em là sau 3 tháng có thể giao tiếp cơ bản tiếng Hàn và sang Hàn để học tiếp, em thấy mình đã chọn đúng trung tâm SMARTEDU',
                'avatar' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Thịnh',
                'content' => 'Mục tiêu của em là sau 3 tháng có thể giao tiếp cơ bản tiếng Hàn và sang Hàn để học tiếp, em thấy mình đã chọn đúng trung tâm SMARTEDU',
                'avatar' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
