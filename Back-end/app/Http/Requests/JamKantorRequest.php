<?php

namespace App\Http\Requests;

class JamKantorRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isUpdate()) {
            return [
                'hari' => 'sometimes|string|in:senin,selasa,rabu,kamis,jumat',
                'awal_masuk' => 'sometimes|date_format:H:i|before:akhir_masuk',
                'akhir_masuk' => 'sometimes|date_format:H:i|after:awal_masuk',
                'awal_istirahat' => 'sometimes|date_format:H:i|before:akhir_istirahat',
                'akhir_istirahat' => 'sometimes|date_format:H:i|after:awal_istirahat',
                'awal_kembali' => 'sometimes|date_format:H:i|before:akhir_kembali',
                'akhir_kembali' => 'sometimes|date_format:H:i|after:awal_kembali',
                'awal_pulang' => 'sometimes|date_format:H:i|before:akhir_pulang',
                'akhir_pulang' => 'sometimes|date_format:H:i|after:awal_pulang',
            ];
        }

        return [
            'hari' => 'required|string|in:senin,selasa,rabu,kamis,jumat',
            'awal_masuk' => 'required|date_format:H:i|before:akhir_masuk',
            'akhir_masuk' => 'required|date_format:H:i|after:awal_masuk',
            'awal_istirahat' => 'required|date_format:H:i|before:akhir_istirahat',
            'akhir_istirahat' => 'required|date_format:H:i|after:awal_istirahat',
            'awal_kembali' => 'required|date_format:H:i|before:akhir_kembali',
            'akhir_kembali' => 'required|date_format:H:i|after:awal_kembali',
            'awal_pulang' => 'required|date_format:H:i|before:akhir_pulang',
            'akhir_pulang' => 'required|date_format:H:i|after:awal_pulang',
        ];
    }

    public function messages(): array
    {
        return [
            'hari.required' => 'Hari wajib diisi.',
            'hari.in' => 'Hari harus salah satu dari senin, selasa, rabu, kamis, atau jumat.',
            'awal_masuk.required' => 'Jam masuk wajib diisi.',
            'awal_masuk.date_format' => 'Format jam masuk tidak valid. Gunakan format HH:MM.',
            'awal_istirahat.required' => 'Jam istirahat mulai wajib diisi.',
            'awal_istirahat.date_format' => 'Format jam istirahat mulai tidak valid. Gunakan format HH:MM.',
            'awal_istirahat.before' => 'Jam istirahat mulai harus sebelum jam istirahat selesai.',
            'akhir_istirahat.required' => 'Jam istirahat selesai wajib diisi.',
            'akhir_istirahat.date_format' => 'Format jam istirahat selesai tidak valid. Gunakan format HH:MM.',
            'akhir_istirahat.after' => 'Jam istirahat selesai harus setelah jam istirahat mulai.',
            'awal_pulang.required' => 'Jam pulang wajib diisi.',
            'awal_pulang.date_format' => 'Format jam pulang tidak valid. Gunakan format HH:MM.',
            'awal_pulang.after' => 'Jam pulang harus setelah jam istirahat selesai.',
        ];
    }
}
