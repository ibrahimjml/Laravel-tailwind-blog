<?php

namespace App\Http\Requests\App\Admin;

use App\Enums\SlidesStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateSlideRequest extends FormRequest
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
              'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
              'title' => 'nullable|string|max:255',
              'description' => 'nullable|string|max:500',
              'link' => 'nullable|url|max:255',
              'status' => ['required', new Enum(SlidesStatus::class)],
        ];
    }
     public function messages(): array
    {
        return [
            'image.required' => 'Please select an image for the slide',
            'image.image' => 'The file must be an image',
            'status.required' => 'Please select a status for the slide',
        ];
    }
}
