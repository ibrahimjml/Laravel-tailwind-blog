<?php

namespace App\Http\Requests\App\Admin;

use App\Enums\SlidesStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateSlideRequest extends FormRequest
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
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:5048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'link' => 'nullable|url|max:255',
            'status' => ['required', new Enum(SlidesStatus::class)],
        ];
    }
}
