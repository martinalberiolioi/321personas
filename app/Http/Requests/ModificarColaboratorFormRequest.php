<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModificarColaboratorFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'txtNombre' => 'required',
            'txtApellido' => 'required',
            'txtEdad' => 'required|integer|between:15,110',
            'txtPuesto' => 'required',
            'idSkill' => 'exists:skills,id'
        ];
    }
}
