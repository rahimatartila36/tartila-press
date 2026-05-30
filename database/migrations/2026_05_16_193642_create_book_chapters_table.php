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
    Schema::create('book_chapters', function (Blueprint $table) {

        $table->id();

        $table->string('cover')->nullable();

        $table->string('title');

        $table->string('category')->nullable();

        $table->string('field')->nullable();

        $table->text('description')->nullable();

        $table->string('estimated_publish')->nullable();

        $table->timestamps();

    });
}
};
