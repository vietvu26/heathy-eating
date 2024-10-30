<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('imports', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('supplier_id'); // Tham chiếu đến nhà cung cấp
        $table->unsignedBigInteger('category_id'); // Tham chiếu đến sản phẩm từ bảng categories
        $table->integer('quantity'); // Số lượng sản phẩm nhập
        $table->decimal('unit_price', 8, 2); // Đơn giá
        $table->decimal('total_price', 10, 2); // Tổng tiền (quantity * unit_price)
        $table->timestamps();

        // Khóa ngoại
        $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imports');
    }
};
