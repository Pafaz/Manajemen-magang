<?php

namespace App\Http\Requests;


class PesertaRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15|regex:/^[0-9]+$/|min_digits:10|max_digits:15',
            'alamat' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_identitas' => 'required|string|max:50',
            'sekolah' => 'required|exists:sekolah,id',
            'jurusan' => 'required|exists:jurusan,id',
            'kelas' => 'required|string|max:10',
            'mulai_magang' => 'required|date',
            'selesai_magang' => 'required|date|after:mulai_magang',
            'profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cv' => 'required|image|mimes:png,jpeg,jpg|max:2048',
            'pernyataan_diri' => 'required|image|mimes:png,jpeg,jpg|max:2048',
            'pernyataan_ortu' => 'required|image|mimes:png,jpeg,jpg|max:2048',
            'perusahaan' => 'required|exists:perusahaan,id',
            'cabang' => 'required|exists:cabang,id',
            'divisi' => 'required|exists:divisi,id',
        ];
    }

    public function messages(): array
    {
        return parent::messages() + [
            'after' => ':attribute harus setelah :date.',
            'telepon.regex' => 'Nomor telepon tidak valid.',
        ];
    }
}
