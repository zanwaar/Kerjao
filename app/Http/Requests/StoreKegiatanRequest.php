<?php

namespace App\Http\Requests;

use App\Enums\StatusKegiatan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $permission = $this->routeIs('kegiatan.update') ? 'kegiatan.edit' : 'kegiatan.create';

        return $this->user()->can($permission);
    }

    public function rules(): array
    {
        return [
            'program_kerja_id' => ['required', 'exists:program_kerja,id'],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'target_capaian' => ['nullable', 'string'],
            'waktu_mulai' => ['required', 'date'],
            'waktu_selesai' => ['required', 'date', 'after_or_equal:waktu_mulai'],
            'status_kegiatan' => ['required', Rule::enum(StatusKegiatan::class)],
        ];
    }
}
