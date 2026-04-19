<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('github_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('todo_list')->cascadeOnDelete();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('repo_name');
            $table->string('branch_name')->nullable();
            $table->string('issue_link')->nullable();
            $table->string('pr_link')->nullable();
            $table->string('commit_hash', 40)->nullable();
            $table->string('commit_message')->nullable();
            $table->timestamp('commit_time')->nullable();
            $table->timestamps();

            $table->index('task_id');
            $table->index('pegawai_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('github_activity');
    }
};
