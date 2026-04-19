<?php

namespace App\Models;

use App\Enums\JenisBukti;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiAktivitas extends Model
{
    use HasFactory;

    protected $table = 'bukti_aktivitas';

    protected $fillable = [
        'task_id',
        'pegawai_id',
        'jenis_bukti',
        'sumber_bukti',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'jenis_bukti' => JenisBukti::class,
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
