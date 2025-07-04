<?php

namespace App\Http\Requests\App;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateUserProfileRequest extends FormRequest
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
      /** @var \App\Models\User $user */
      $user = $this->user();
      $imageRule = 'nullable|image|mimes:png,jpeg,jpg|max:5048';

        return [
            'avatar'   => $imageRule,
            'cover'    => $imageRule,
            "name"     => ["required", "min:3", "max:50", "alpha"],
            "phone"    => ['required', 'regex:/^\+\d{8,15}$/', Rule::unique(User::class)->ignore($user->id)],
            'bio'      =>'nullable|min:5|string',
            'about'    =>'nullable|string|min:10|max:255',
            'github'   => 'nullable|url|starts_with:https',
            'linkedin' => 'nullable|url|starts_with:https',
            'twitter'     => 'nullable|url|starts_with:https',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'nullable|string',
            'social_links.*.url' => 'nullable|url|starts_with:https',

        ];
    }
    public function messages()
    {
        return [
            'phone.regex' => 'The phone number must include a valid country code.',
            'avatar.image' => 'The avatar must be an image file.',
            'avatar.max' => 'The avatar image must be 5MB.',
            'avatar.mimes' => 'The avatar must be a PNG, JPG, or JPEG.',
            'cover.image' => 'The cover must be an image file.',
            'cover.max' => 'The cover image must be 5MB.',
            'cover.mimes' => 'The cover must be a PNG, JPG, or JPEG.',
        ];
    }
}
