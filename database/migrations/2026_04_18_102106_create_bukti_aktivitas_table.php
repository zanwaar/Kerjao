<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('todo_list')->cascadeOnDelete();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->enum('jenis_bukti', ['link', 'dokumen', 'foto', 'catatan', 'lainnya']);
            $table->string('sumber_bukti');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('task_id');
            $table->index('pegawai_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_aktivitas');
    }
};
