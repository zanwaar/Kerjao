<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todo_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnDelete();
            $table->foreignId('assigned_to')->constrained('pegawai');
            $table->foreignId('created_by')->constrained('users');
            $table->string('nama_task');
            $table->text('deskripsi_task')->nullable();
            $table->enum('status', ['not_started', 'on_progress', 'done', 'canceled'])->default('not_started');
            $table->enum('prioritas', ['low', 'medium', 'high'])->default('medium');
            $table->unsignedTinyInteger('progress_persen')->default(0);
            $table->date('due_date')->nullable();
            $table->text('catatan_monev')->nullable();
            $table->timestamps();

            $table->index('kegiatan_id');
            $table->index('assigned_to');
            $table->index('status');
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todo_list');
    }
};
