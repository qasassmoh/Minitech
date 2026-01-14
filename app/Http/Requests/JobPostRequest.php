<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Job Post Form Request
 * Following Single Responsibility Principle - only handles job post validation
 * Following Open/Closed Principle - can be extended without modifying base validation
 */
class JobPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     * Only admins can create/update job posts
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request
     * Defines all validation rules for job post creation and updates
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'experience_required' => 'nullable|string|max:255',
            'deadline' => 'nullable|date|after:today',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors
     * Provides user-friendly error messages
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'description.required' => 'The job description is required.',
            'company_name.required' => 'The company name is required.',
            'salary_max.gte' => 'The maximum salary must be greater than or equal to the minimum salary.',
            'deadline.after' => 'The deadline must be a future date.',
        ];
    }

    /**
     * Get validated data with additional processing
     * Prepares data for storage, including is_active flag
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);
        
        // Ensure is_active is set (default to true if not provided)
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = $this->has('is_active');
        }

        return $validated;
    }
}
