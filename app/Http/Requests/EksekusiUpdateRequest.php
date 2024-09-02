<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EksekusiUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'jenis_perkara_id' => 'required',
            // 'institution_category_part_id' => 'required',
            'status' => 'required',
            'name' => 'required',
            'jpu' => 'required',
            'kasus_posisi' => 'required',
            'asal_perkara' => 'required',
            'pidana_badan' => 'required',
            'subsider_pidana_badan' => 'required',
            'denda' => 'required',
            'subsider_denda' => 'required',
            'uang_pengganti' => 'required',
            'barang_bukti' => 'required',
            'pelelangan_benda_sitaan' => 'required',
            'keterangan' => 'required',
            'pelelangan_benda_sitaan' => 'required',
        ];
    }
}
