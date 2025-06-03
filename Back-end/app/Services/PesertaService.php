<?php

namespace App\Services;

use App\Helpers\Api;
use App\Services\FotoService;
use App\Interfaces\RouteInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MagangInterface;
use App\Interfaces\PesertaInterface;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\JurnalResource;
use App\Http\Resources\PesertaResource;
use App\Http\Resources\PesertaDetailResource;
use App\Http\Resources\PesertaJurnalResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\PesertaByDivisiResource;
use App\Http\Resources\PesertabyMentorResource;
use App\Http\Resources\ProgressPesertaResource;
use App\Http\Resources\PesertaKehadiranResource;
use App\Http\Resources\PesertaDivisiRouteResource;
use App\Http\Resources\RouteDetailPesertaResource;

class PesertaService
{
    private PesertaInterface $pesertaInterface;
    private RouteInterface $routeInterface;
    private FotoService $foto;

    public function __construct(PesertaInterface $pesertaInterface, FotoService $foto, RouteInterface $routeInterface)
    {
        $this->foto = $foto;
        $this->pesertaInterface = $pesertaInterface;
        $this->routeInterface = $routeInterface;
    }

    public function getPeserta($id = null, $isUpdate = false)
    {
        $cacheKey = $isUpdate ? "peserta_". $id : "peserta_all";

        $data = Cache::remember($cacheKey, 3600, function () use ($id, $isUpdate) {
            $peserta = $isUpdate ? $this->pesertaInterface->find($id) : $this->pesertaInterface->getAll();
            return $peserta;
        });
            
        return Api::response(
            PesertaDetailResource::collection($data),
            'Berhasil mengambil data peserta', 
        );
    }

    public function getPesertaDetail()
    {
        if (!auth()->user()->peserta) {
            return Api::response(
                null,
                'Data Peserta Tidak Ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }
        $id_peserta = auth()->user()->peserta->id;
        $cacheKey = 'peserta_detail_'. $id_peserta;
        $data = Cache::remember($cacheKey, 3600, function () use ($id_peserta) {
            return $this->pesertaInterface->find($id_peserta);
        });

        return Api::response(
            PesertaResource::make($data),
            'Data Peserta Berhasil Ditampilkan',
        );
    }

    public function getPesertaByCabang()
    {
        $cabang = auth('sanctum')->user()->id_cabang_aktif;
        $cacheKey = 'peserta_cabang_'. $cabang;
        $data = Cache::remember($cacheKey, 360, function () use ( $cabang ) {
            return $this->pesertaInterface->getByCabang($cabang);
        });

        return Api::response(
            PesertaResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getPesertaByDivisi($id_divisi)
    {
        $cacheKey = 'peserta_divisi_'. $id_divisi;
        $data = Cache::remember($cacheKey, 120, function () use ($id_divisi) {
            return $this->pesertaInterface->getByDivisi($id_divisi);
        });

        return Api::response(
            PesertaByDivisiResource::collection($data),
            'Peserta sesuai divisi berhasil ditampilkan',
        );
    }

    public function getJurnalPesertaByCabang(){
        $cabang = auth('sanctum')->user()->id_cabang_aktif;
        $cacheKey = 'jurnal_cabang_'. $cabang;
        $data = Cache::remember($cacheKey, 120, function () use ($cabang) {
            return $this->pesertaInterface->getJurnalPeserta($cabang);
        });

        return Api::response(
            PesertaJurnalResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getKehadiranPesertaByCabang()
    {
        $cabang = auth('sanctum')->user()->id_cabang_aktif;
        $cacheKey = 'presensi_cabang'. $cabang;
        $data = Cache::remember($cacheKey,120, function () use ($cabang) {
            return $this->pesertaInterface->getKehadiranPeserta($cabang);
        });

        return Api::response(
            PesertaKehadiranResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function markDoneRoute($idPeserta, $idKategoriProyek)
    {
        $this->routeInterface->markFinished($idPeserta, $idKategoriProyek);

        $peserta = $this->pesertaInterface->find($idPeserta);
        if (!$peserta || !$peserta->magang || !$peserta->magang->divisi) {
            return Api::response(null, 'Peserta atau divisi tidak valid', Response::HTTP_NOT_FOUND);
        }

        Cache::forget('peserta_detail_' . $idPeserta);

        $kategoriList = $peserta->magang->divisi->kategori->sortBy('pivot.urutan')->values();
        $currentIndex = $kategoriList->search(fn($kategori) => $kategori->id == $idKategoriProyek);
        $nextKategori = $kategoriList->get($currentIndex + 1);
        if ($nextKategori) {
            $this->routeInterface->markStarted($idPeserta, $nextKategori->id);
        }
        return Api::response(
            null,
            'Berhasil menandai route selesai' . ($nextKategori ? ' dan memulai kategori berikutnya' : ''),
        );
    }
    
    public function getPesertaByProgress(){
        $idMentor = auth()->user()->mentor->id;
        $cacheKey = 'progres_peserta_'. $idMentor;
        $data = Cache::remember($cacheKey, 120, function () use ($idMentor) {
            return $this->pesertaInterface->getByProgress($idMentor);
        });
        
        return Api::response(
            PesertabyMentorResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getDetailProgressByMentor($idPeserta)
    {
        $idMentor = auth()->user()->mentor->id;
        $data = $this->pesertaInterface->getDetailProgressByMentor($idMentor, $idPeserta);
        return Api::response(
            ProgressPesertaResource::make($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getDivisiRoute()
    {
        $cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->pesertaInterface->getDivisiRoute($cabang);
        // dd($data);
        return Api::response(
            PesertaDivisiRouteResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getDetailRoute($idRoute)
    {
        $cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->pesertaInterface->getDetailRoute($idRoute, $cabang);
        // dd($data);
        return Api::response(
            RouteDetailPesertaResource::make($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function isCompleteProfil()
    {
        if (!auth()->user()->peserta) {
            return Api::response(
                'false',
                'Peserta belum melengkapi profil',
                Response::HTTP_OK
            );
        }

        return Api::response(
            'true',
            'Peserta telah melengkapi profil',
            Response::HTTP_OK
        );
    }

    public function isApplyLowongan()
    {
        $dataMagang = auth()->user()->peserta->magang;

        if ($dataMagang == null) {
            return Api::response(
                'false',
                'Peserta belum Apply Lowongan'
            );
        } else {
            return Api::response(
                'true',
                'Peserta telah Apply Lowongan'
            );
        }
    }

    public function isMagang(){
        if (!auth()->user()->id_cabang_aktif) {
            return Api::response(
                'false',
                'Peserta belum terdaftar magang',
            );
        }

        return Api::response(
            'true',
            'Peserta telah terdaftar magang',
        );
    }

    public function checkAllStatus()
    {
        $user = auth('sanctum')->user();

        $peserta = $user->peserta;
        $id_cabang_aktif = $user->id_cabang_aktif;

        $isProfilLengkap = $peserta !== null;
        $isMagang = $id_cabang_aktif !== null;

        return Api::response(
            [
                'is_profil_lengkap' => $isProfilLengkap,
                'is_magang' => $isMagang,
            ],
            'Status berhasil diambil',
            200,
        );
    }

    public function simpanProfilPeserta(array $data, bool $isUpdate = false, $id = null)
    {
        DB::beginTransaction();
        try {
            $user = auth('sanctum')->user();

            if (!$isUpdate && $user->peserta) {
                throw new \Exception("Anda sudah melengkapi profil");
            }

            $dataPeserta = collect($data)->only([
                'nama', 'telepon', 'alamat', 'jenis_kelamin', 'tempat_lahir', 
                'tanggal_lahir', 'nomor_identitas', 'sekolah', 'jurusan'
            ])->toArray();

            if (!$isUpdate) {
                $dataPeserta['id_user'] = $user->id;
            }

            $peserta = $isUpdate
                ? $this->pesertaInterface->update($id, $dataPeserta)
                : $this->pesertaInterface->create($dataPeserta);

            $peserta->user->update([
                'nama' => $data['nama'],
                'telepon' => $data['telepon']
            ]);

            // Handle foto
            $files = [
                'profile' => 'profile',
                'cv' => 'cv',
            ];

            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    $this->foto->updateFoto($data[$key], $peserta->id, $tipe, 'peserta');
                }
            }

            DB::commit();

            Cache::forget('peserta_all');
            Cache::forget('peserta_detail_' . $peserta->id);

            $message = $isUpdate
                ? 'Peserta berhasil memperbarui profil'
                : 'Peserta berhasil melengkapi profil';

            $statusCode = $isUpdate
                ? Response::HTTP_OK
                : Response::HTTP_CREATED;

            return Api::response(
                PesertaResource::make($peserta),
                $message,
                $statusCode
            );

        } catch (\Throwable $th) {
            DB::rollBack();
            return Api::response(
                null,
                'Gagal menyimpan profil peserta: ' . $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deletePeserta( $id)
    {
        $this->pesertaInterface->delete($id);

        Cache::forget('peserta_detail_' . $id);
        Cache::forget('peserta_all');

        return Api::response(
            null,
            'Peserta Deleted Successfully',
            Response::HTTP_OK
        );
    }

}
