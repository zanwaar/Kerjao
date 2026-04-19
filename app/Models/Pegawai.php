<?php

namespace App\Models;

use App\Enums\StatusPegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'user_id',
        'nama_pegawai',
        'nip',
        'jabatan',
        'unit_kerja',
        'status_pegawai',
        'github_username',
        'wakatime_user_key',
    ];

    protected function casts(): array
    {
        return [
            'status_pegawai' => StatusPegawai::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(TodoList::class, 'assigned_to');
    }

    public function dailyScrums(): HasMany
    {
        return $this->hasMany(DailyScrum::class);
    }

    public function buktiAktivitas(): HasMany
    {
        return $this->hasMany(BuktiAktivitas::class);
    }

    public function githubActivities(): HasMany
    {
        return $this->hasMany(GithubActivity::class);
    }

    public function wakatimeActivities(): HasMany
    {
        return $this->hasMany(WakatimeActivity::class);
    }
}
