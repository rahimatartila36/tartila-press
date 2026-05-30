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
    Schema::create('royalties', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('book_title');

        $table->integer('sold_qty')->default(0);

        $table->decimal('total_sales', 12, 2)
            ->default(0);

        $table->decimal('royalty_percent', 5, 2)
            ->default(30);

        $table->decimal('royalty_amount', 12, 2)
            ->default(0);

        $table->enum('status', [
            'belum_dibayar',
            'sudah_dibayar'
        ])->default('belum_dibayar');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('royalties');
    }
};
