<?php

namespace App\Enums;

enum StatusTask: string
{
    case NotStarted = 'not_started';
    case OnProgress = 'on_progress';
    case Done = 'done';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::NotStarted => 'Belum Dimulai',
            self::OnProgress => 'Sedang Berjalan',
            self::Done => 'Selesai',
            self::Canceled => 'Dibatalkan',
        };
    }
}
