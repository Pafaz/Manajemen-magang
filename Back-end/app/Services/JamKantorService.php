<?php 

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\JamKantorResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\JamKantorInterface;
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
        $data = $this->jamKantorInterface->getAll()->where('id_cabang', $idCabang);

        return Api::response($data, 'Jam Kantor Berhasil ditampilkan');
    }

    public function getJamKantorToday()
    {
        $user = auth('sanctum')->user();

        if (!$user || !$user->id_cabang_aktif) {
            return null;
        }

        $hariIni = strtolower(now()->locale('id')->dayName);
        return $this->jamKantorInterface->getAll()
            ->where('id_cabang', $user->id_cabang_aktif)
            ->firstWhere('hari', $hariIni);
    }



    public function simpanJamKantor(array $data, $id = null)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        DB::beginTransaction();

        // dd($data, $id_cabang, $id);

        try {
            if ($id) {
                $jamKantor = $this->jamKantorInterface->update($id, $data);
            } else {
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
                ]);
            }

            DB::commit();

            return Api::response(
                new JamKantorResource($jamKantor),
                $id ? 'Jam Kantor Berhasil di update' : 'Jam Kantor berhasil dibuat',
                $id ? Response::HTTP_OK : Response::HTTP_CREATED,
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return Api::response(null,'Gagal Menyimpan data Jam Kantor: ' . $e->getMessage());
        }
    }
}
