<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
            'kode' => 'required|max:5|unique:barang,kode,' . $this->barang->id,
            'nama' => 'required|min:3',
            'jenis' => 'required|in:1,2',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'harga_beli_matauang' => 'required',
            'harga_jual_matauang' => 'required',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'harga_jual_min' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'min_sotk' => 'required|integer|min:0',
            'gambar' => 'nullable|image',
            'status' => 'required|in:Y,N',
        ];
    }
}
