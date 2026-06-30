<?php

namespace App\Http\Requests\App\Admin;

use App\Enums\ScrapingType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SourceScrapingRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:2048'],
            'type' => ['required', new Enum(ScrapingType::class)],
            'favicon_url' => ['nullable','url'],
            'max_links' => ['required', 'integer', 'min:1', 'max:200'],
            'max_age_hours' => ['required',"integer",'min:1'],
            'skip_no_image' => ['nullable','boolean'],
            'skip_no_category' => ['nullable','boolean'],
            'is_active' => ['nullable','boolean'],
          ];
    }
}