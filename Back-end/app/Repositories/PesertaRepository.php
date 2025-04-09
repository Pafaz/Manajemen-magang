<?php

namespace App\Repositories;

use App\Models\Peserta;
use App\Interfaces\PesertaInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class PesertaRepository implements PesertaInterface
{
    public function getAll(): Collection
    {
        return Peserta::all();
    }

    public function find(int $id): ? Peserta
    {
        return Peserta::findOrFail($id)->first();
    }

    public function create(array $data): ? Peserta
    {
        return Peserta::create([ 
            'id_user' => Auth::user()->id,
            'id_magang' => $data['id_magang'],
            'id_jurusan' => $data['id_jurusan'],
            'id_sekolah' => $data['id_sekolah'],
            'nomor_identitas' => $data['nomor_identitas'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'kelas' => $data['kelas'],
            'alamat' => $data['alamat'],
            'status' => $data['status'],
            'CV' => $data['CV'],
            'pernyataan_diri' => $data['pernyataan_diri'],
            'pernyataan_orang_tua' => $data['pernyataan_orang_tua'],
        ]);
    }

    public function update(int $id, array $data): mixed
    {
        return Peserta::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Peserta::findOrFail($id)->delete();
    }
}
