<?php

namespace App\Http\Requests;

use App\Enums\PrioritasTask;
use App\Enums\StatusTask;
use App\Models\TodoList;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTodoListRequest extends FormRequest
{
    private function task(): ?TodoList
    {
        $task = $this->route('task');

        return $task instanceof TodoList ? $task : null;
    }

    private function canManageTask(): bool
    {
        $task = $this->task();

        return $task instanceof TodoList && $task->canBeManagedBy($this->user());
    }

    private function isLimitedAssigneeUpdate(): bool
    {
        return $this->routeIs('task.update') && ! $this->canManageTask();
    }

    protected function prepareForValidation(): void
    {
        $status = $this->input('status');
        $progress = $this->input('progress_persen');

        if ($status === null || $progress === null) {
            return;
        }

        $normalizedProgress = (int) $progress;

        if ($status === StatusTask::Done->value) {
            $this->merge(['progress_persen' => 100]);

            return;
        }

        if ($normalizedProgress === 100) {
            $this->merge(['status' => StatusTask::Done->value]);
        }
    }

    public function authorize(): bool
    {
        if ($this->routeIs('task.update')) {
            $task = $this->task();

            return $this->user()->can('task.edit')
                && $task instanceof TodoList
                && $task->canBeUpdatedBy($this->user());
        }

        return $this->user()->can('task.create')
            && ($this->user()->can('task.view-all') || $this->user()->pegawai !== null);
    }

    public function rules(): array
    {
        if ($this->isLimitedAssigneeUpdate()) {
            return [
                'status' => ['required', Rule::enum(StatusTask::class)],
                'progress_persen' => ['required', 'integer', 'min:0', 'max:100'],
                'catatan_monev' => ['nullable', 'string'],
            ];
        }

        $kegiatanRule = Rule::exists('kegiatan', 'id');
        $assignedToRule = Rule::exists('pegawai', 'id');

        if (! $this->user()->can('task.view-all')) {
            $kegiatanRule = $kegiatanRule->where(fn ($query) => $query->where('created_by', $this->user()->id));
            $assignedToRule = $assignedToRule->where(
                fn ($query) => $query->where('id', $this->user()->pegawai?->id)
            );
        }

        return [
            'kegiatan_id' => ['required', $kegiatanRule],
            'assigned_to' => ['required', $assignedToRule],
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
