<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImageoptimizationRequest extends FormRequest
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
            'enable_image_optimization' => 'sometimes|boolean',
            'image_compression_quality' => 'sometimes|integer|min:0|max:100',
            'image_output_format' => ['sometimes',Rule::enum(\App\Enums\ImageTypes::class)],
            'image_max_upload_size' => 'sometimes|numeric|min:0.01',
        ];
    }
}
