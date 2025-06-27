<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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

        'title' => 'required|string|regex:/^[A-Za-z0-9\s]+$/|max:50|min:6',
        'description' => 'required|string',
        'hashtag' => ['nullable', 'string', function ($attribute, $value, $fail) {
          
          $tags = array_filter(array_map('trim', explode(',', $value)));
          if (count($tags) > 5) {
              $fail('You can only select up to 5 hashtags.');
          }
          $regexTags = '/^[A-Za-z0-9_-]+$/';
          foreach( $tags as $tag){
            if(!preg_match($regexTags,$tag)){
              $fail("Hashtags only contain letters, numbers, dashes, or underscores");
            }
          }
    }],
        'image' => 'required|image|mimes:jpg,png,jpeg|max:5120',
        'enabled' => 'nullable|boolean',
        'featured' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'title.regex' => 'The title may only contain letters, numbers, and spaces.',
            'image.max' => 'The image may not be greater than 5MB.'
        ];
    }
}
