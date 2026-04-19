<?php

namespace App\Http\Requests;

use App\Enums\StatusProgram;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProgramKerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $permission = $this->routeIs('program-kerja.update') ? 'program-kerja.edit' : 'program-kerja.create';

        return $this->user()->can($permission);
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
