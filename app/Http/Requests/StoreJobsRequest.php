<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'work_type' => ['required', 'in:onsite,remote,hybrid,freelance'],
            'city_id' => ['required', 'exists:cities,id'],
            'vacancies' => ['required', 'numeric', "gt:0"],
            'min_salary' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $min_salary = floatval(str_replace(',', '', $this->input('min_salary')));
                    if ($min_salary <= 0)
                        $fail('The minimum salary must be greater than 0.');
                }
            ],
            'max_salary' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $min_salary = floatval(str_replace(',', '', $this->input('min_salary')));
                    $max_salary = floatval(str_replace(',', '', $this->input('max_salary')));
                    if ($max_salary <= 0)
                        $fail('The maximum salary must be greater than 0.');
                    else if ($max_salary < $min_salary)
                        $fail('The maximum salary must be greater than the minimum salary.');
                }
            ],
            'deadline' => ['required', 'date', 'after:now'],
            'description' => ['required'],
            'qualifications' => ['required'],
            'responsibilities' => ['required'],
            'benefits' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title.',
            'work_type.required' => 'Please select a work type.',
            'work_type.exists' => 'Please select valid work type.',
            'city.required' => 'Please select a city.',
            'city.exists' => 'Please select valid city.',
            'vacancies.required' => 'Please enter number of vacancies.',
            'vacancies.numeric' => 'Please enter valid number of vacancies.',
            'vacancies.gt' => 'Number of vacancies must be greater than or equal to 1.',
            'min_salary.required' => 'Please enter a minimum salary.',
            'min_salary.numeric' => 'Please enter valid minimum salary.',
            'max_salary.required' => 'Please enter a maximum salary.',
            'max_salary.numeric' => 'Please enter valid maximum salary.',
            'deadline.required' => 'Please enter a deadline.',
            'deadline.date' => 'Please enter a valid date.',
            'deadline.after' => 'Please enter a valid date.',
            'description.required' => 'Please enter job description.',
            'qualifications.required' => 'Please enter job qualifications.',
            'responsibilities.required' => 'Please enter job responsibilities.',
            'benefits.required' => 'Please enter job benefits.',
        ];
    }
}
