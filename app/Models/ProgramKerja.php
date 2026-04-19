<?php

namespace App\Models;

use App\Enums\StatusProgram;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramKerja extends Model
{
    use HasFactory;

    protected $table = 'program_kerja';

    protected $fillable = [
        'created_by',
        'nama_program',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
        'status_program',
    ];

    protected function casts(): array
    {
        return [
            'waktu_mulai' => 'date',
            'waktu_selesai' => 'date',
            'status_program' => StatusProgram::class,
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->created_by === $user->id;
    }

    public function canBeManagedBy(User $user): bool
    {
        return $user->can('task.view-all') || $this->isOwnedBy($user);
    }

    public function scopeOwnedBy(Builder $query, User $user): Builder
    {
        return $query->where('created_by', $user->id);
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->can('task.view-all')) {
            return $query;
        }

        $pegawai = $user->pegawai;

        if (! $pegawai) {
            return $query->ownedBy($user);
        }

        return $query->where(function (Builder $programQuery) use ($pegawai, $user): void {
            $programQuery->ownedBy($user)
                ->orWhereHas('kegiatan.tasks', fn (Builder $taskQuery) => $taskQuery->assignedTo($pegawai->id));
        });
    }
}
