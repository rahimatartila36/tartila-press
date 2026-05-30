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
    Schema::create('book_chapter_items', function (Blueprint $table) {

        $table->id();

        $table->foreignId('book_chapter_id')
              ->constrained('book_chapters')
              ->cascadeOnDelete();

        $table->string('chapter_title');

        $table->decimal('price', 12, 2)->default(0);

        $table->integer('discount')->default(0);

        $table->enum('status', [
            'available',
            'pending',
            'sold'
        ])->default('available');

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_chapter_items');
    }
};
