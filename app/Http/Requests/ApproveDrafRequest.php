<?php

namespace App\Http\Requests;

use App\Enums\ApprovalDecision;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApproveDrafRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isApprover() ?? false;
    }

    public function rules(): array
    {
        return [
            'approval' => ['required', Rule::in(array_map(fn ($case) => $case->value, ApprovalDecision::cases()))],
            'reason2' => ['nullable', 'string'],
            'approved_by' => ['required', 'exists:users,id'],
            'approved_at' => ['required', 'date'],
            'new_revision_number' => ['nullable', 'string', 'max:50'],
            'effectivity_date' => ['nullable', 'date'],
            'date_registered' => ['nullable', 'date'],
            'approved_attachment_url' => ['nullable', 'url', 'max:2048'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('reason2', 'required|string', function ($input) {
            return ($input->approval ?? null) === ApprovalDecision::DISAPPROVED->value;
        });

        $validator->sometimes('new_revision_number', 'required|string', function ($input) {
            return ($input->approval ?? null) === ApprovalDecision::APPROVED->value;
        });

        $validator->sometimes('effectivity_date', 'required|date', function ($input) {
            return ($input->approval ?? null) === ApprovalDecision::APPROVED->value;
        });

        $validator->sometimes('date_registered', 'required|date', function ($input) {
            return ($input->approval ?? null) === ApprovalDecision::APPROVED->value
                && ! empty($input->approved_attachment_url);
        });
    }
}
