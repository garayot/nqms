<?php

namespace App\Http\Requests;

use App\Models\Position;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->isAdmin();
    }

    public function rules(): array
    {
        $position = $this->route('position');

        return [
            'position_name' => ['required', 'string', 'max:150', Rule::unique((new Position)->getTable(), 'position_name')->ignore($position)],
        ];
    }
}
