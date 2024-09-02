<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenuntutanUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules($id)
    {
        return [
            'jenis_perkara_id' => 'required',
            // 'institution_category_part_id' => 'required',
            'status' => 'required',
            'name' => 'required',
            'no_spdp' => 'required|unique:penuntutans,no_spdp,' . $id,
            'date_spdp' => 'required',
            'kasus_posisi' => 'required',
            'asal_perkara' => 'required',
        ];
    }
}