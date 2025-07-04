<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use App\Interfaces\JurusanInterface;
use App\Interfaces\SekolahInterface;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\SchoolResource;
use Symfony\Component\HttpFoundation\Response;

class SekolahService
{
    private SekolahInterface $SekolahInterface;
    private JurusanInterface $JurusanInterface;
    private FotoService $foto;

    public function __construct(SekolahInterface $SekolahInterface, JurusanInterface $JurusanInterface, FotoService $foto)
    {
        $this->JurusanInterface = $JurusanInterface;
        $this->SekolahInterface = $SekolahInterface;
        $this->foto = $foto;
    }

    public function getSchools($id = null)
    {
        $id_perusahaan = auth('sanctum')->user()->perusahaan->id;
        $cacheKey = $id ? 'mitra_'.$id : 'mitra_perusahaan_'. $id_perusahaan;
        $school = Cache::remember($cacheKey, 3600, function () use ($id_perusahaan, $id) {
            $data = $id ? $this->SekolahInterface->find($id) : $this->SekolahInterface->getAll($id_perusahaan);
            return $data;
        });

        if (!$school) {
            return Api::response(null, 'Sekolah tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $data = $id
            ? SchoolResource::make($school)
            : SchoolResource::collection($school);

        $message = $id
            ? 'Berhasil mengambil data sekolah'
            : 'Berhasil mengambil semua data sekolah';

        return Api::response($data, $message);
    }


    public function simpanMitra(array $data, bool $isUpdate = false, $id = null)
    {
        DB::beginTransaction();
        try {
            $user = auth('sanctum')->user();

            if (!$user->perusahaan) {
                throw new \Exception("Lengkapi profil perusahaan anda terlebih dahulu");
            }
            $dataSekolah = collect($data)->only(['nama', 'alamat', 'telepon', 'jenis_institusi'])->toArray();
            $dataSekolah['id_perusahaan'] = auth('sanctum')->user()->perusahaan->id;
            $sekolah = $isUpdate
                ? $this->SekolahInterface->update($id, $dataSekolah)
                : $this->SekolahInterface->create($dataSekolah);

            $jurusanIds = [];
            if (!empty($data['jurusan'])) {
                foreach ($data['jurusan'] as $namaJurusan) {
                    $jurusan = $this->JurusanInterface->firstOrCreate(['nama' => $namaJurusan]);
                    $jurusanIds[] = $jurusan->id;
                }
                $sekolah->jurusan()->sync($jurusanIds);
            }

            $files = [
                'foto_header' => 'foto_header',
                'logo' => 'logo',
            ];
            foreach ($files as $key => $type) {
                if (!empty($data[$key])) {
                    $this->foto->updateFoto($data[$key], $sekolah->id, $type, 'sekolah');
                }
            }

            DB::commit();

            $message = $isUpdate
                ? 'Sekolah & jurusan berhasil diperbarui'
                : 'Sekolah & jurusan berhasil disimpan';

            $id_perusahaan = auth('sanctum')->user()->perusahaan->id;

            if ($isUpdate === true) {
                Cache::forget('mitra_'.$id);
                Cache::forget('mitra_perusahaan_'.$id_perusahaan);
            } else {
                Cache::forget('mitra_perusahaan_'.$id_perusahaan);
            }

            $statusCode = $isUpdate
                ? Response::HTTP_OK
                : Response::HTTP_CREATED;

            return Api::response(
                SchoolResource::make($sekolah->load('jurusan', 'foto')),
                $message,
                $statusCode
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return Api::response(
                null,
                'Gagal menyimpan sekolah: ' . $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteSchool(int $id)
    {
        $school = $this->SekolahInterface->find($id);

        $school->jurusan()->detach();
        $school->delete();
        return Api::response(
            null,
            'Berhasil menghapus data sekolah',
            Response::HTTP_OK
        );
    }
}
