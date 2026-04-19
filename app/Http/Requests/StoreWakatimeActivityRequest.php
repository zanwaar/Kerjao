<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWakatimeActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('wakatime-activity.create');
    }

    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:todo_list,id'],
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'activity_date' => ['required', 'date'],
            'project_name' => ['required', 'string', 'max:255'],
            'language_name' => ['nullable', 'string', 'max:100'],
            'duration_hours' => ['required', 'numeric', 'min:0', 'max:24'],
            'description' => ['nullable', 'string'],
        ];
    }
}
