<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenyelidikanRequest extends FormRequest
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
            'no_sp' => 'required|unique:penyelidikans,no_sp,' . $id,
            'date_sp' => 'required',
            'kasus_posisi' => 'required',
            'asal_perkara' => 'required',
            'jenis_perkara_prioritas' => 'required',
            'keterangan' => 'required',
            'pnbp' => 'required',
        ];
    }
}
