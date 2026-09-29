<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcessRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->isAdmin();
    }

    public function rules(): array
    {
        return [
            'process_name' => ['required', 'string', 'max:255'],
            'process_group_id' => ['required', 'exists:process_groups,id'],
        ];
    }
}
