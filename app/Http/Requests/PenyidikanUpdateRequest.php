<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenyidikanUpdateRequest extends FormRequest
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
            'pekerjaan_id' => 'required',
            'nilai_kerugian' => 'required',
            'no_sp_dik' => 'required|unique:penyidikans,no_sp_dik,' . $id,
            'date_sp_dik' => 'required',
            'jpu' => 'required',
            'kasus_posisi' => 'required',
            'asal_perkara' => 'required',
            'jenis_perkara_prioritas' => 'required',
            'perkara_pasal_35_ayat_1' => 'required',
            'keterangan' => 'required',
            'penyelamatan_kerugian_negara' => 'required',
        ];
    }
}
