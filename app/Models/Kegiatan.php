<?php

namespace App\Models;

use App\Enums\StatusKegiatan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'program_kerja_id',
        'created_by',
        'nama_kegiatan',
        'deskripsi',
        'target_capaian',
        'waktu_mulai',
        'waktu_selesai',
        'status_kegiatan',
    ];

    protected function casts(): array
    {
        return [
            'waktu_mulai' => 'date',
            'waktu_selesai' => 'date',
            'status_kegiatan' => StatusKegiatan::class,
        ];
    }

    public function programKerja(): BelongsTo
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(TodoList::class);
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

        return $query->whereHas('tasks', fn (Builder $taskQuery) => $taskQuery->assignedTo($pegawai->id));
    }
}
