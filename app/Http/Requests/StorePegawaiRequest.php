<?php

namespace App\Http\Requests;

use App\Enums\StatusPegawai;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('pegawai.create');
    }

    public function rules(): array
    {
        $pegawaiId = $this->route('pegawai')?->id;

        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'nama_pegawai' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:30', Rule::unique('pegawai', 'nip')->ignore($pegawaiId)],
            'jabatan' => ['required', 'string', 'max:255'],
            'unit_kerja' => ['required', 'string', 'max:255'],
            'status_pegawai' => ['required', Rule::enum(StatusPegawai::class)],
            'github_username' => ['nullable', 'string', 'max:100'],
            'wakatime_user_key' => ['nullable', 'string', 'max:255'],
        ];
    }
}
