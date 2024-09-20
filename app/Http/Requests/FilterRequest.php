<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
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
        $sortParameters = [
            'price_desc',
            'price_asc',
        ];

        return [
            'sort' => [
                'sometimes',
                'string',
                Rule::in($sortParameters),
            ],
            'price' => ['sometimes', 'array'],
            'price.*' => ['numeric'],

            'category' => ['sometimes', 'array'],
            'category.*' => ['numeric', 'exists:categories,id'],

            'q' => ['sometimes', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->serializePrice();

        $this->serializeCategory();
    }

    /**
     * Преобразование параметра запроса из вида "0-100" или "100" в массив
     *
     * @return void
     */
    private function serializePrice(): void
    {
        if ($this->price) {
            $priceRange = explode('-', $this->price);
            if (count($priceRange) === 1) {
                $this->merge([
                    'price' => [
                        0,
                        $priceRange[0],
                    ],
                ]);
            } else {
                $this->merge([
                    'price' => [
                        $priceRange[0],
                        $priceRange[1],
                    ],
                ]);
            }
        }
    }

    /**
     * Преобразование параметра запроса из вида "1,2,3" или "1" в массив
     *
     * @return void
     */
    private function serializeCategory(): void
    {
        if ($this->category) {
            $categories = explode(',', $this->category);
            $this->merge([
                'category' => $categories,
            ]);
        }

    }
}
