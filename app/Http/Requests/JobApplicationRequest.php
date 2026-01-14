<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Job Application Form Request
 * Following Single Responsibility Principle - only handles job application validation
 * Following Open/Closed Principle - can be extended without modifying base validation
 */
class JobApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     * Only authenticated users can apply for jobs
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request
     * Defines all validation rules for job application submission
     */
    public function rules(): array
    {
        return [
            'resume' => 'required|file|mimes:pdf|max:5120', // PDF only, max 5MB
            'cover_letter' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Get custom messages for validator errors
     * Provides user-friendly error messages
     */
    public function messages(): array
    {
        return [
            'resume.required' => 'Please upload your resume (PDF file).',
            'resume.file' => 'The resume must be a valid file.',
            'resume.mimes' => 'The resume must be a PDF file.',
            'resume.max' => 'The resume file size must not exceed 5MB.',
            'cover_letter.max' => 'The cover letter must not exceed 2000 characters.',
        ];
    }
}
