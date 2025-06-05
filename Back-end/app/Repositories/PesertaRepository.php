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

    public function getRouteById($idPeserta)
    {
        return Peserta::with([
            'magang.divisi.kategori',
            'route'
        ])
        ->where('id', $idPeserta)
        ->get()
        ->map(function ($peserta) {
            $routes = $peserta->route->map(function ($route) use ($peserta) {
                $kategoriProyek = $peserta->magang->divisi->kategori->firstWhere('id', $route->id_kategori_proyek);
                return [
                    'id_route' => $route->id,
                    'nama_kategori_proyek' => $kategoriProyek ? $kategoriProyek->nama : 'Tidak Ditemukan',
                    'mulai' => $route->mulai,
                    'selesai' => $route->selesai
                ];
            });

            return $routes;
        })
        ->flatten(1);
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
                $query->where('status', 'diterima') 
                    ->where('id_mentor', null)
                    ->whereHas('lowongan.divisi', function ($query) use ($idDivisi) {
                        $query->where('id_divisi', $idDivisi); 
                    });
            })
            ->get();
    }

    // public function getByProgress($idMentor): Collection
    // {
    //     return Peserta::with([
    //         'user',
    //         'route.kategoriProyek',
    //         'foto',
    //         'magang.mentor',
    //         'revisi.progress'
    //     ])
    //     ->whereHas('magang.mentor', function ($query) use ($idMentor) {
    //         $query->where('id', $idMentor);
    //     })
    //     ->get();
    // }

    public function getByProgress($idMentor): Collection
    {
        $peserta = Peserta::with([
                'user',
                'route.kategoriProyek',
                'magang.mentor',
                'revisi.progress',
                'foto'
            ])
            ->whereHas('magang.mentor', function ($query) use ($idMentor) {
                $query->where('id', $idMentor);
            })
            ->get();

        $flattenedData = new Collection();
        
        foreach ($peserta as $p) {
            foreach ($p->route as $route) {
                $pesertaClone = clone $p;
                $pesertaClone->current_route = $route;
                $flattenedData->push($pesertaClone);
            }
        }
        
        return $flattenedData;
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

    public function find( $id): Peserta
    {
        $peserta = Peserta::findOrFail( $id);
        $peserta->first();
        return $peserta;
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
