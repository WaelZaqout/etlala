<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=>'required|exists:users,id',
            'total_price'=>'required|numeric|min:0',
            'status'=>'required|in:pending,processing,completed,cancelled',
        ];
    }

    /**
     * Custom messages (اختياري)
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'حقل المستخدم مطلوب.',
            'user_id.exists' => 'المستخدم المختار غير موجود.',
            'total_price.required' => 'إجمالي السعر مطلوب.',
            'total_price.numeric' => 'إجمالي السعر يجب أن يكون رقمًا.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'الحالة المختارة غير صالحة. القيم المسموح بها: pending, processing, completed, cancelled.',
        ];
    }
}
