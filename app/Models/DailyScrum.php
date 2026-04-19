<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyScrum extends Model
{
    use HasFactory;

    protected $table = 'daily_scrum';

    protected $fillable = [
        'pegawai_id',
        'task_id',
        'tanggal',
        'rencana_kerja_harian',
        'indikator_capaian',
        'potensi_risiko',
        'realisasi',
        'rencana_tindak_lanjut',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(TodoList::class, 'task_id');
    }
}
