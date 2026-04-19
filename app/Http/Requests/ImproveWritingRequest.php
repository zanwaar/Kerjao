<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImproveWritingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $context = (string) $this->input('context');

        return match (true) {
            str_starts_with($context, 'task_') => $user?->can('task.create') || $user?->can('task.edit'),
            str_starts_with($context, 'daily_') => $user?->can('daily-scrum.create') || $user?->can('daily-scrum.edit'),
            default => false,
        };
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'context' => [
                'required',
                'string',
                Rule::in([
                    'task_description',
                    'task_monitoring_note',
                    'daily_plan',
                    'daily_indicator',
                    'daily_risk',
                    'daily_realization',
                    'daily_follow_up',
                ]),
            ],
            'text' => ['required', 'string', 'max:5000'],
        ];
    }
}
