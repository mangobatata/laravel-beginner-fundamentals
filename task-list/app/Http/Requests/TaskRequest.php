<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// TaskRequest es una clase que sirve para validar y autorizar datos antes de que lleguen a tu controlador.
// Extiende de FormRequest, que es una forma más limpia y profesional de manejar validaciones.
class TaskRequest extends FormRequest
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
            'title' => 'required|max:255',
            'description' => 'required',
            'long_description' => 'required',
        ];
    }
}
