<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramStudiRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        $mataKuliahId = $this->route('mata_kuliah')->id;

        return [
            'program_studi_id' => ['sometimes', 'required', 'integer', 'exists:program_studis,id'],
            'kode_mk' => [
                'sometimes', 'required', 'string', 'max:20',
                Rule::unique('mata_kuliahs', 'kode_mk')->ignore($mataKuliahId),
            ],
            'nama_mk' => ['sometimes', 'required', 'string', 'max:150'],
            'sks' => ['sometimes', 'required', 'integer', 'between:1,6'],
            'semester' => ['sometimes', 'required', 'integer', 'between:1,14'],
            'status_aktif' => ['sometimes', 'boolean'],
        ];
    }
}
