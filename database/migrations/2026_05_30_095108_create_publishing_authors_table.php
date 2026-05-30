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
       Schema::create('publishing_authors', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('publishing_submission_id');

$table->foreign('publishing_submission_id')
    ->references('id')
    ->on('publishing_submissions')
    ->onDelete('cascade');

    $table->string('name');
    $table->string('phone')->nullable();
    $table->string('nik')->nullable();
    $table->text('address')->nullable();
    $table->string('email')->nullable();

    $table->integer('order')->default(1);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishing_authors');
    }
};
