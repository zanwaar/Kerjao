<?php

namespace App\Http\Requests;

use App\Enums\StatusProgram;
use App\Models\ProgramKerja;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProgramKerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->routeIs('program-kerja.update')) {
            $programKerja = $this->route('program_kerja');

            return $this->user()->can('program-kerja.edit')
                && $programKerja instanceof ProgramKerja
                && $programKerja->canBeManagedBy($this->user());
        }

        return $this->user()->can('program-kerja.create');
    }

    public function rules(): array
    {
        return [
            'nama_program' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'waktu_mulai' => ['required', 'date'],
            'waktu_selesai' => ['required', 'date', 'after_or_equal:waktu_mulai'],
            'status_program' => ['required', Rule::enum(StatusProgram::class)],
        ];
    }
}
