<?php

namespace App\Http\Requests;

use App\Enums\DrafApplicability;
use App\Enums\DrafRequestType;
use App\Enums\DrafSource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDrafRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'draf_number' => ['nullable', 'string', 'max:255', Rule::unique('drafs', 'draf_number')->ignore($this->route('draf'))],
            'source' => ['required', Rule::in(array_map(fn ($case) => $case->value, DrafSource::cases()))],
            'request_for' => ['required', Rule::in(array_map(fn ($case) => $case->value, DrafRequestType::cases()))],
            'doc_type_id' => ['required', 'exists:document_types,id'],
            'applicability' => ['required', Rule::in(array_map(fn ($case) => $case->value, DrafApplicability::cases()))],
            'title' => ['required', 'string', 'max:255'],
            'reference_code' => ['nullable', 'string', 'max:255'],
            'current_revision_no' => ['required', 'string', 'max:50'],
            'reason_id' => ['nullable', 'exists:reasons,id', 'required_without:open_ended_reason'],
            'open_ended_reason' => ['nullable', 'string', 'max:4000', 'required_without:reason_id'],
            'date_requested' => ['required', 'date'],
            'attachment_url' => ['nullable', 'url', 'max:2048'],
        ];
    }
}
