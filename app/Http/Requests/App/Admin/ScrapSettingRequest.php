<?php

namespace App\Http\Requests\App\Admin;

use App\Enums\ScrapFrequency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ScrapSettingRequest extends FormRequest
{

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
            'auto_scrap_enabled' => ['sometimes','boolean'],
            'crawl_frequency' => ['sometimes', new Enum(ScrapFrequency::class)],
        ];
    }
}
