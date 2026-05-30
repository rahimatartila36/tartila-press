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
        Schema::create('publishing_submissions', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();

    $table->string('book_title')->nullable();
    $table->string('manuscript_file')->nullable();
    $table->string('edited_file')->nullable();

    $table->enum('status', [
        'menunggu_upload_naskah',
        'naskah_dikirim',
        'cek_admin',
        'dikirim_ke_editor',
        'proses_editing',
        'review_penulis',
        'acc_penulis',
        'pengajuan_isbn',
        'isbn_terbit',
        'pengajuan_haki',
        'haki_terbit',
        'input_katalog',
        'terbit',
        'selesai',
    ])->default('menunggu_upload_naskah');

    $table->text('admin_note')->nullable();
    $table->text('editor_note')->nullable();
    $table->timestamp('author_approved_at')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishing_submissions');
    }
};
