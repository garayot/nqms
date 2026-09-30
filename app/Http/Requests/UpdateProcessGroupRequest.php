<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcessGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->isAdmin();
    }

    public function rules(): array
    {
        return [
            'process_group_name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:2048'],
        ];
    }
}
