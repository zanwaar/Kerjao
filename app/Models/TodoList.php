<?php

namespace App\Models;

use App\Enums\PrioritasTask;
use App\Enums\StatusTask;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TodoList extends Model
{
    use HasFactory;

    protected $table = 'todo_list';

    protected $fillable = [
        'kegiatan_id',
        'assigned_to',
        'created_by',
        'nama_task',
        'deskripsi_task',
        'status',
        'prioritas',
        'progress_persen',
        'due_date',
        'catatan_monev',
    ];

    protected $attributes = [
        'status' => 'not_started',
        'prioritas' => 'medium',
        'progress_persen' => 0,
    ];

    protected function casts(): array
    {
        return [
            'status' => StatusTask::class,
            'prioritas' => PrioritasTask::class,
            'due_date' => 'date',
            'progress_persen' => 'integer',
        ];
    }

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dailyScrums(): HasMany
    {
        return $this->hasMany(DailyScrum::class, 'task_id');
    }

    public function buktiAktivitas(): HasMany
    {
        return $this->hasMany(BuktiAktivitas::class, 'task_id');
    }

    public function githubActivities(): HasMany
    {
        return $this->hasMany(GithubActivity::class, 'task_id');
    }

    public function wakatimeActivities(): HasMany
    {
        return $this->hasMany(WakatimeActivity::class, 'task_id');
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->whereNotIn('status', [StatusTask::Done->value, StatusTask::Canceled->value])
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->toDateString());
    }

    public function scopeAssignedTo(Builder $query, int $pegawaiId): Builder
    {
        return $query->where('assigned_to', $pegawaiId);
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->can('task.view-all')) {
            return $query;
        }

        $pegawai = $user->pegawai;

        if (! $pegawai) {
            return $query->whereRaw('1 = 0');
        }

        return $query->assignedTo($pegawai->id);
    }
}
