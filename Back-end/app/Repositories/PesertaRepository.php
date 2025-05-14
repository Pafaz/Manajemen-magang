<?php

namespace App\Repositories;

use Carbon\Carbon;
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
        return Peserta::with([
                'user',
                'magang',
                'kehadiran',
                'absensi',
                'rekapKehadiran',
                'jurnal' => function ($query) {
                    $query->whereDate('tanggal', Carbon::now('Asia/Jakarta')->toDateString());
                }
            ])
            ->whereHas('user', function ($query) use ($idCabang) {
                $query->where('id_cabang_aktif', $idCabang);
            })
            ->get();
    }
    public function find( $id): ? Peserta
    {
        return Peserta::where('id_user', auth('sanctum')->user()->id);
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
