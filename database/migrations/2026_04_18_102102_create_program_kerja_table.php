<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users');
            $table->string('nama_program');
            $table->text('deskripsi')->nullable();
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->enum('status_program', ['planning', 'active', 'completed', 'on_hold'])->default('planning');
            $table->timestamps();

            $table->index('status_program');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_kerja');
    }
};
