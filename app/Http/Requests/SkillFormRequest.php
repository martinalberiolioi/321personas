<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillFormRequest extends FormRequest
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
            'idColab' => 'required|exists:colaborators,id',
            'idSkill' => 'required|exists:skills,id'
        ];
    }
}
