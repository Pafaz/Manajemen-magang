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

    public function updateStatusJamKantor($id, $status)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        DB::beginTransaction();

        try {
            // Find the Jam Kantor entry by its ID and check if it's from the active branch
            $jamKantor = $this->jamKantorInterface->find($id);

            if ($jamKantor && $jamKantor->id_cabang == $id_cabang) {
                // Update the status of the Jam Kantor
                $jamKantor->status = $status;
                $jamKantor->save();

                DB::commit();

                return Api::response(
                    new JamKantorResource($jamKantor),
                    'Status Jam Kantor berhasil diupdate',
                    Response::HTTP_OK
                );
            } else {
                return Api::response(null, 'Jam Kantor tidak ditemukan atau tidak sesuai dengan cabang aktif', Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return Api::response(null, 'Gagal Mengubah status Jam Kantor: ' . $e->getMessage());
        }
    }

}
