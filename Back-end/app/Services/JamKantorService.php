<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\JamKantorInterface;
use App\Http\Resources\JamKantorResource;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class JamKantorService
{
    private JamKantorInterface $jamKantorInterface;

    public function __construct(JamKantorInterface $jamKantorInterface)
    {
        $this->jamKantorInterface = $jamKantorInterface;
    }

    public function getJamKantor()
    {
        $idCabang = auth('sanctum')->user()->id_cabang_aktif;
        $keyCache = 'jam_kantor_cabang_'. $idCabang;

        $data = Cache::remember($keyCache, 3600, function () use ($idCabang) {
            return $this->jamKantorInterface->getAll()->where('id_cabang', $idCabang);
        });

        return Api::response(JamKantorResource::collection($data), 'Jam Kantor Berhasil ditampilkan');
    }

    public function getJamKantorToday()
    {
        $user = auth('sanctum')->user();

        if (!$user || !$user->id_cabang_aktif) {
            return null;
        }
        
        $hariIni = strtolower(Carbon::now('Asia/Jakarta')->locale('id')->dayName);
        return $this->jamKantorInterface->getAll()
            ->where('id_cabang', $user->id_cabang_aktif)
            ->where('status',true)
            ->firstWhere('hari', $hariIni);
    }

    public function simpanJamKantor(array $data, $hari = null)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        DB::beginTransaction();

        try {
            if ($hari) {
                 $jamKantor = $this->jamKantorInterface->updateByHari($hari, $id_cabang, $data);
            } else {
                // Buat data baru jika tidak ada hari
                $jamKantor = $this->jamKantorInterface->create([
                    'id_cabang' => $id_cabang,
                    'hari' => $data['hari'],
                    'awal_masuk'=> $data['awal_masuk'],
                    'akhir_masuk'=> $data['akhir_masuk'],
                    'awal_istirahat'=> $data['awal_istirahat'],
                    'akhir_istirahat'=> $data['akhir_istirahat'],
                    'awal_kembali'=> $data['awal_kembali'],
                    'akhir_kembali'=> $data['akhir_kembali'],
                    'awal_pulang'=> $data['awal_pulang'],
                    'akhir_pulang'=> $data['akhir_pulang'],
                    'status' => true,
                ]);
            }

            DB::commit();

            return Api::response(
                new JamKantorResource($jamKantor),
                $hari ? 'Jam Kantor Berhasil di update' : 'Jam Kantor berhasil dibuat',
                $hari ? Response::HTTP_OK : Response::HTTP_CREATED,
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return Api::response(null,'Gagal Menyimpan data Jam Kantor: ' . $e->getMessage());
        }
    }

    public function updateStatusJamKantor($hari, $status)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        DB::beginTransaction();

        try {
            $jamKantor = $this->jamKantorInterface->findByHariAndCabang($hari, $id_cabang);

            if ($jamKantor) {
                $jamKantor->status = $status;
                $jamKantor->save();

                DB::commit();

                $message = $status ? 'Jam kantor berhasil diaktifkan' : 'Jam kantor berhasil dinonaktifkan';

                return Api::response(
                    new JamKantorResource($jamKantor),
                    $message,
                    Response::HTTP_OK
                );
            } else {
                return Api::response(null, 'Jam kantor tidak ditemukan untuk cabang ini', Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return Api::response(null, 'Gagal Mengubah status Jam Kantor: ' . $e->getMessage());
        }
    }

}
