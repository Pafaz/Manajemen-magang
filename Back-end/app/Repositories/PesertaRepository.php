<?php

namespace App\Repositories;

use App\Models\User;
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


    public function getByCabang($idCabang): Collection
    {
        return Peserta::join('users', 'peserta.id_user', '=', 'users.id')
            ->where('users.id_cabang_aktif', $idCabang)
            ->select('peserta.*') 
            ->get();
    }


    public function find( $id): ? Peserta
    {
        return Peserta::findOrFail($id)->first();
    }

    public function create(array $data): ? Peserta
    {
        return Peserta::create([ 
            'id_user' => $data['id_user'],
            'jurusan' => $data['jurusan'],
            'sekolah' => $data['sekolah'],
            'nomor_identitas' => $data['nomor_identitas'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat'],
        ]);
    }

    public function update( $id, array $data): Peserta
    {
        $peserta = Peserta::findOrFail($id)->first();
        $peserta->update($data);
        
        return $peserta;
    }

    public function delete( $id): void
    {
        Peserta::findOrFail($id)->delete();
    }
}
