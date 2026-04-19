<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGithubActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('github-activity.create');
    }

    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:todo_list,id'],
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'repo_name' => ['required', 'string', 'max:255'],
            'branch_name' => ['nullable', 'string', 'max:255'],
            'issue_link' => ['nullable', 'url', 'max:500'],
            'pr_link' => ['nullable', 'url', 'max:500'],
            'commit_hash' => ['nullable', 'string', 'max:40'],
            'commit_message' => ['nullable', 'string', 'max:500'],
            'commit_time' => ['nullable', 'date'],
        ];
    }
}
