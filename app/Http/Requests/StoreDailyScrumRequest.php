<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyScrumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('daily-scrum.create');
    }

    public function rules(): array
    {
        return [
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'task_id' => ['required', 'exists:todo_list,id'],
            'tanggal' => ['required', 'date'],
            'rencana_kerja_harian' => ['required', 'string'],
            'indikator_capaian' => ['nullable', 'string'],
            'potensi_risiko' => ['nullable', 'string'],
            'realisasi' => ['nullable', 'string'],
            'rencana_tindak_lanjut' => ['nullable', 'string'],
        ];
    }
}
