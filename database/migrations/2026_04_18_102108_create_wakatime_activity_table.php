<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wakatime_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('todo_list')->cascadeOnDelete();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->date('activity_date');
            $table->string('project_name');
            $table->string('language_name')->nullable();
            $table->decimal('duration_hours', 5, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('task_id');
            $table->index('pegawai_id');
            $table->index('activity_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wakatime_activity');
    }
};
