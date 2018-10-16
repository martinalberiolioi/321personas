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
            'nombre' => 'required',
            'apellido' => 'required',
            'edad' => 'required|integer|between:15,110',
            'dni' => 'required|integer|unique:colaborators,dni',
            'legajo' => 'required|integer|unique:colaborators,legajo',
            'puesto' => 'required',
            'mail' => 'required|unique:colaborators,mail|email',
            'idSkill' => 'required|exists:skills,id'
        ];
    }
}
