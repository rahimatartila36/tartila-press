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
    Schema::table('book_chapter_items', function (Blueprint $table) {
        $table->decimal('price', 12, 2)->nullable()->change();
        $table->integer('discount')->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('book_chapter_items', function (Blueprint $table) {
        $table->decimal('price', 12, 2)->default(0)->change();
        $table->integer('discount')->default(0)->change();
    });
}
};
