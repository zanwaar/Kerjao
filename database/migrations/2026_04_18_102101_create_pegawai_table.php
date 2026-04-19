<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_pegawai');
            $table->string('nip', 30)->nullable()->unique();
            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->enum('status_pegawai', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('github_username')->nullable();
            $table->string('wakatime_user_key')->nullable();
            $table->timestamps();

            $table->index('status_pegawai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
