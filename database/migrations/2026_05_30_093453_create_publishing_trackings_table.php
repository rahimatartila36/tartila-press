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
    Schema::create('publishing_trackings', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('book_title');

        $table->enum('status', [
            'draft',
            'editing',
            'pengajuan_isbn',
            'isbn_terbit',
            'pengajuan_haki',
            'haki_terbit',
            'cetak_buku',
            'buku_terkirim',
            'selesai'
        ])->default('draft');

        $table->text('note')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishing_trackings');
    }
};
