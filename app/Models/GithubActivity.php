<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GithubActivity extends Model
{
    use HasFactory;

    protected $table = 'github_activity';

    protected $fillable = [
        'task_id',
        'pegawai_id',
        'repo_name',
        'branch_name',
        'issue_link',
        'pr_link',
        'commit_hash',
        'commit_message',
        'commit_time',
    ];

    protected function casts(): array
    {
        return [
            'commit_time' => 'datetime',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(TodoList::class, 'task_id');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
