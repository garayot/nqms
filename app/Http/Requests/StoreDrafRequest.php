<?php

namespace App\Http\Requests;

use App\Enums\DrafApplicability;
use App\Enums\DrafRequestType;
use App\Enums\DrafSource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDrafRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'draf_number' => ['required', 'string', 'max:255', Rule::unique('drafs', 'draf_number')],
            'source' => ['required', Rule::in(array_map(fn ($case) => $case->value, DrafSource::cases()))],
            'request_for' => ['required', Rule::in(array_map(fn ($case) => $case->value, DrafRequestType::cases()))],
            'doc_type_id' => ['required', 'exists:document_types,id'],
            'applicability' => ['required', Rule::in(array_map(fn ($case) => $case->value, DrafApplicability::cases()))],
            'title' => ['required', 'string', 'max:255'],
            'reference_code' => ['nullable', 'string', 'max:255'],
            'current_revision_no' => ['required', 'string', 'max:50'],
            'reason' => ['required', 'string'],
            'requested_by' => ['required', 'exists:users,id'],
            'date_requested' => ['required', 'date'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png', 'max:2048'],
        ];
    }
}
