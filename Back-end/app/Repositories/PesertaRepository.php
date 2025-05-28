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

    public function getDivisiRoute($idCabang)
    {
        return Peserta::with([
            'user',
            'magang.divisi.kategori',
            'route'
        ])->whereHas('user', function ($query) use ($idCabang) {
                $query->where('id_cabang_aktif', $idCabang);
            })
            ->get();
    }

    public function getDetailRoute($idRoute, $idCabang)
    {
        return Peserta::with('revisi.progress', 'route', 'magang.mentor', 'user', 'magang.divisi')
        ->whereHas('user', function ($query) use ($idCabang) {
            $query->where('id_cabang_aktif', $idCabang);
        })
        ->whereHas('route', function ($query) use ($idRoute) {
            $query->where('id', $idRoute);
        })->first();
    }
    public function getByCabang($idCabang): Collection
    {
        return Peserta::with([
                'user',
                'magang.lowongan.divisi'
            ])
            ->whereHas('user', function ($query) use ($idCabang) {
                $query->where('id_cabang_aktif', $idCabang)
                    ->whereNotNull('id_cabang_aktif');
            })
            ->get();
    }

    public function getByDivisi($idDivisi)
    {
        return Peserta::with([
                'user',
                'magang.lowongan.divisi',
            ])
            ->whereHas('magang', function ($query) use ($idDivisi) {
                $query->where('status', 'diterima') // Memfilter berdasarkan status di tabel magang
                    ->whereHas('lowongan.divisi', function ($query) use ($idDivisi) {
                        $query->where('id_divisi', $idDivisi); // Memfilter berdasarkan id_divisi yang ada di divisi
                    });
            })
            ->get();
    }

    public function getByProgress($idMentor): Collection
    {
        return Peserta::with([
                'user',
                'route',
                'magang.mentor',
                'revisi.progress'
            ])
            ->whereHas('magang.mentor', function ($query) use ($idMentor) {
                $query->where('id', $idMentor);
            })
            ->get();
    }

    public function getJurnalPeserta($idCabang)
    {
        return Peserta::with('jurnal')->whereHas('user', function ($query) use ($idCabang) {
                $query->where('id_cabang_aktif', $idCabang);
            })
            ->get();
    }

    public function getKehadiranPeserta($idCabang)
    {
        return Peserta::with('kehadiran', 'absensi')->whereHas('user', function ($query) use ($idCabang) {
                $query->where('id_cabang_aktif', $idCabang);
            })
            ->get();
    }

    public function getDetailProgressByMentor($idMentor, $idPeserta)
    {
        return Peserta::with([
            'user',
            'route',
            'revisi.progress'
        ])->whereHas('magang.mentor', function ($query) use ($idMentor) {
                $query->where('id', $idMentor);
            })
        ->findOrFail($idPeserta);

    }
    public function find( $id): ? Peserta
    {
        return Peserta::where('id', $id)->first();
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
