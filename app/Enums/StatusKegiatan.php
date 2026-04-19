<?php

namespace App\Enums;

enum StatusKegiatan: string
{
    case Planning = 'planning';
    case Active = 'active';
    case Completed = 'completed';
    case OnHold = 'on_hold';

    public function label(): string
    {
        return match($this) {
            self::Planning => 'Perencanaan',
            self::Active => 'Aktif',
            self::Completed => 'Selesai',
            self::OnHold => 'Ditunda',
        };
    }
}
