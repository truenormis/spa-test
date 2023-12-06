<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
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
        $allowedTags = '<a><code><i><strong><q>'; // Замените это на список разрешенных тегов

        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[^<>]*$/'],
            'email' => ['required', 'email', 'max:255', 'regex:/^[^<>]*$/'],
            'reply' => [
                'required',
                'string',
                'max:500',
                function ($attribute, $value, $fail) use ($allowedTags) {
                    $filteredValue = strip_tags($value, $allowedTags);

                    if ($value !== $filteredValue) {
                        $fail('has incorrect tags');
                    }
                },
            ],
            'files' => [
                'array',
                'max:5',
                function ($attribute, $value, $fail) {
                    foreach ($value as $file) {
                        if (!$file->isValid()) {
                            $fail('One of the files is not a valid file.');
                        }

                        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'txt'];
                        $extension = strtolower($file->getClientOriginalExtension());

                        if (!in_array($extension, $allowedExtensions)) {
                            $fail('One of the files has an invalid extension.');
                        }

                        if ($extension === 'txt') {

                            $maxSize = 100 * 1024;
                            if ($file->getSize() > $maxSize) {
                                $fail('Text file should not exceed 100 KB.');
                            }
                        }
                    }
                },
            ],
            'files.*' => 'max:12288',
            'captcha' => 'required'

        ];
    }
}
