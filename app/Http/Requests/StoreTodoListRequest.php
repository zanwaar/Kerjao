<?php

namespace App\Http\Requests;

use App\Enums\PrioritasTask;
use App\Enums\StatusTask;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTodoListRequest extends FormRequest
{
    public function authorize(): bool
    {
        $permission = $this->routeIs('task.update') ? 'task.edit' : 'task.create';

        return $this->user()->can($permission);
    }

    public function rules(): array
    {
        return [
            'kegiatan_id' => ['required', 'exists:kegiatan,id'],
            'assigned_to' => ['required', 'exists:pegawai,id'],
            'nama_task' => ['required', 'string', 'max:255'],
            'deskripsi_task' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(StatusTask::class)],
            'prioritas' => ['required', Rule::enum(PrioritasTask::class)],
            'progress_persen' => ['required', 'integer', 'min:0', 'max:100'],
            'due_date' => ['nullable', 'date'],
            'catatan_monev' => ['nullable', 'string'],
        ];
    }
}
