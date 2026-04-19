<?php

namespace App\Enums;

enum JenisBukti: string
{
    case Link = 'link';
    case Dokumen = 'dokumen';
    case Foto = 'foto';
    case Catatan = 'catatan';
    case Lainnya = 'lainnya';

    public function label(): string
    {
        return match($this) {
            self::Link => 'Link',
            self::Dokumen => 'Dokumen',
            self::Foto => 'Foto',
            self::Catatan => 'Catatan',
            self::Lainnya => 'Lainnya',
        };
    }
}
