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
        Schema::table('consultation_requests', function (Blueprint $table) {
            $table->text('note')->nullable()->after('content');            // ghi chú nội bộ của tư vấn viên
            $table->string('source')->nullable()->after('note');          // trang khách gửi form (vd. /blogs/abc)
            $table->timestamp('handled_at')->nullable()->after('status'); // lần đầu chuyển khỏi trạng thái "Mới"
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropColumn(['note', 'source', 'handled_at']);
        });
    }
};
