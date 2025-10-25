<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // يمكنك تعديلها لاحقًا للتحقق من صلاحية المستخدم
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $productId = $this->route('product'); // assuming route parameter is {product}

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            // 'sale_price' => 'nullable|numeric|min:0|lte:price',
            // 'stock' => 'required|integer|min:0',
        ];
    }

    /**
     * Custom messages (اختياري)
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'حقل الفئة مطلوب.',
            'category_id.exists' => 'الفئة المختارة غير موجودة.',
            'name.required' => 'اسم المنتج مطلوب.',
            'slug.required' => 'الرابط الخاص بالمنتج مطلوب.',
            'slug.unique' => 'هذا الرابط مستخدم من قبل.',
            'price.required' => 'سعر المنتج مطلوب.',
            'price.numeric' => 'سعر المنتج يجب أن يكون رقمًا.',
            'sale_price.lte' => 'سعر التخفيض يجب أن يكون أقل أو يساوي السعر الأصلي.',
            'image.image' => 'يجب أن يكون الملف صورة.',
            'stock.required' => 'كمية المنتج مطلوبة.',
        ];
    }
}
