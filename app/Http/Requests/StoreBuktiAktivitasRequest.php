<?php

namespace App\Http\Requests;

use App\Enums\JenisBukti;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBuktiAktivitasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('bukti-aktivitas.create');
    }

    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:todo_list,id'],
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'jenis_bukti' => ['required', Rule::enum(JenisBukti::class)],
            'sumber_bukti' => ['required', 'string', 'max:500'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
