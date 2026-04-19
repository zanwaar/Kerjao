<?php

namespace App\Enums;

enum StatusPegawai: string
{
    case Aktif = 'aktif';
    case Nonaktif = 'nonaktif';

    public function label(): string
    {
        return match($this) {
            self::Aktif => 'Aktif',
            self::Nonaktif => 'Non-Aktif',
        };
    }
}
