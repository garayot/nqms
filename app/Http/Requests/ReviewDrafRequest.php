<?php

namespace App\Http\Requests;

use App\Enums\ReviewDecision;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewDrafRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isApprover());
    }

    public function rules(): array
    {
        return [
            'review' => ['required', Rule::in(array_map(fn ($case) => $case->value, ReviewDecision::cases()))],
            'reason1' => ['nullable', 'string'],
            'reviewed_by' => ['required', 'exists:users,id'],
            'reviewed_at' => ['required', 'date'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('reason1', 'required|string', function ($input) {
            return ($input->review ?? null) === ReviewDecision::DISAPPROVED->value;
        });
    }
}
