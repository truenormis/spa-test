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
            'name' => "required|string|max:255",
            'email' => "required|email|max:255",
            'reply' => [
                'required',
                'string',
                'max:500',
                function ($attribute, $value, $fail) use ($allowedTags) {
                    // Удаление всех тегов, кроме разрешенных
                    $filteredValue = strip_tags($value, $allowedTags);

                    // Проверка, изменилось ли значение после фильтрации
                    if ($value !== $filteredValue) {
                        $fail($attribute . ' содержит недопустимые теги.');
                    }
                },
            ],
            'files' => [
                'array',
                'max:5', // Максимальное количество файлов
                function ($attribute, $value, $fail) {
                    foreach ($value as $file) {
                        if (!$file->isValid()) {
                            $fail('Один из файлов не является допустимым файлом.');
                        }

                        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'txt'];
                        $extension = strtolower($file->getClientOriginalExtension());

                        if (!in_array($extension, $allowedExtensions)) {
                            $fail('Один из файлов имеет недопустимое расширение.');
                        }

                        if ($extension === 'txt') {
                            // Если файл - текстовый, не должен весить больше 100 КБ
                            $maxSize = 100 * 1024; // 100 КБ в байтах
                            if ($file->getSize() > $maxSize) {
                                $fail('Текстовый файл не должен превышать 100 КБ.');
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
