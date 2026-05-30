<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable()->after('book_id');
            }

            if (!Schema::hasColumn('payments', 'book_chapter_item_id')) {
                $table->unsignedBigInteger('book_chapter_item_id')->nullable()->after('order_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'book_chapter_item_id')) {
                $table->dropColumn('book_chapter_item_id');
            }

            if (Schema::hasColumn('payments', 'order_id')) {
                $table->dropColumn('order_id');
            }
        });
    }
};