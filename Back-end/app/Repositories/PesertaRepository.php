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

    public function getByPerusahaan( $id): Collection
    {
        return Peserta::where('id_perusahaan', $id)->get();
    }

    public function find( $id): ? Peserta
    {
        return Peserta::findOrFail($id)->first();
    }

    public function create(array $data): ? Peserta
    {
        return Peserta::create([ 
            'id_user' => $data['id_user'],
            'id_jurusan' => $data['id_jurusan'],
            'id_sekolah' => $data['id_sekolah'],
            'nomor_identitas' => $data['nomor_identitas'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'kelas' => $data['kelas'],
            'alamat' => $data['alamat'],
        ]);
    }

    public function update( $id, array $data): Peserta
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->update($data);
        
        return $peserta;
    }

    public function delete( $id): void
    {
        Peserta::findOrFail($id)->delete();
    }
}
