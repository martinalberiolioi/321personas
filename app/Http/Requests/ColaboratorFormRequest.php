<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColaboratorFormRequest extends FormRequest
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
            'txtDni' => 'required|integer|unique:colaborators,dni',
            'txtLegajo' => 'required|integer|unique:colaborators,legajo',
            'txtPuesto' => 'required',
            'txtMail' => 'required|unique:colaborators,mail|email',
            'idSkill' => 'required|exists:skills,id'
        ];
    }
}
