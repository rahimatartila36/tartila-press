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
    Schema::table('payments', function (Blueprint $table) {

        $table->foreignId('book_chapter_item_id')
              ->nullable()
              ->after('book_id')
              ->constrained('book_chapter_items')
              ->nullOnDelete();

    });
}
};
