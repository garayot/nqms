<?php

namespace App\Http\Requests;

use App\Enums\QmsOrganizationRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQmsOrganizationMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, ValidationRule|string>>
     */
    public function rules(): array
    {
        $validRoles = array_map(static fn (QmsOrganizationRole $role): string => $role->value, QmsOrganizationRole::cases());

        return [
            'role' => ['required', 'string', Rule::in($validRoles)],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
