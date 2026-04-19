<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WakatimeActivity extends Model
{
    use HasFactory;

    protected $table = 'wakatime_activity';

    protected $fillable = [
        'task_id',
        'pegawai_id',
        'activity_date',
        'project_name',
        'language_name',
        'duration_hours',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'duration_hours' => 'decimal:2',
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
