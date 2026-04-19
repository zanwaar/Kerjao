<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_scrum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->foreignId('task_id')->constrained('todo_list')->cascadeOnDelete();
            $table->date('tanggal');
            $table->text('rencana_kerja_harian');
            $table->text('indikator_capaian')->nullable();
            $table->text('potensi_risiko')->nullable();
            $table->text('realisasi')->nullable();
            $table->text('rencana_tindak_lanjut')->nullable();
            $table->timestamps();

            $table->index('pegawai_id');
            $table->index('task_id');
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_scrum');
    }
};
