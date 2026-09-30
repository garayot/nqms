<?php

namespace App\Http\Requests;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->isAdmin();
    }

    public function rules(): array
    {
        return [
            'team_name' => ['required', 'string', 'max:255', Rule::unique((new Team)->getTable(), 'team_name')],
            'abbreviation' => ['required', 'string', 'max:20', Rule::unique((new Team)->getTable(), 'abbreviation')],
        ];
    }
}
