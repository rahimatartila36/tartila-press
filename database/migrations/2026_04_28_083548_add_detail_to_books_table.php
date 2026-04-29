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
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn')->nullable();
            $table->text('editor')->nullable();
            $table->text('penyunting')->nullable();
            $table->text('desain')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->integer('harga')->nullable();
            $table->integer('diskon')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'isbn',
                'editor',
                'penyunting',
                'desain',
                'penerbit',
                'kategori',
                'tahun_terbit',
                'harga',
                'diskon',
            ]);
        });
    }
};
