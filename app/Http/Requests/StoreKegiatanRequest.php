<?php

namespace App\Http\Requests;

use App\Enums\StatusKegiatan;
use App\Models\Kegiatan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->routeIs('kegiatan.update')) {
            $kegiatan = $this->route('kegiatan');

            return $this->user()->can('kegiatan.edit')
                && $kegiatan instanceof Kegiatan
                && $kegiatan->canBeManagedBy($this->user());
        }

        return $this->user()->can('kegiatan.create');
    }

    public function rules(): array
    {
        $programKerjaRule = Rule::exists('program_kerja', 'id');

        if (! $this->user()->can('task.view-all')) {
            $programKerjaRule = $programKerjaRule->where(fn ($query) => $query->where('created_by', $this->user()->id));
        }

        return [
            'program_kerja_id' => ['required', $programKerjaRule],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'target_capaian' => ['nullable', 'string'],
            'waktu_mulai' => ['required', 'date'],
            'waktu_selesai' => ['required', 'date', 'after_or_equal:waktu_mulai'],
            'status_kegiatan' => ['required', Rule::enum(StatusKegiatan::class)],
        ];
    }
}
