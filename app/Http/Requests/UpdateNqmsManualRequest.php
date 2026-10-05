<?php

namespace App\Http\Requests;

use App\Enums\DocumentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNqmsManualRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'document_type_id' => ['required', 'exists:document_types,id'],
            'document_reference_code' => ['required', 'string', 'max:255', Rule::unique('nqms_manuals', 'document_reference_code')->ignore($this->route('nqmsManual'))],
            'doc_title' => ['required', 'string', 'max:255'],
            'responsible' => ['required', 'string', 'max:255'],
            'revision_number' => ['nullable', 'string', 'max:255'],
            'effectivity_date' => ['nullable', 'date'],
            'document_location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_map(fn ($status) => $status->value, DocumentStatus::cases()))],
            'downloadable_attachment_url' => ['nullable', 'url', 'max:2048'],
        ];
    }
}
