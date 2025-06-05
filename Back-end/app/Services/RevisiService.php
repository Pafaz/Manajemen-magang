<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\RouteInterface;
use App\Interfaces\RevisiInterface;
use App\Interfaces\ProgressInterface;
use Symfony\Component\HttpFoundation\Response;


class RevisiService
{
    private RevisiInterface $revisiInterface;
    private ProgressInterface $progressInterface;
    public function __construct(RevisiInterface $revisiInterface, ProgressInterface $progressInterface)
    {
        $this->revisiInterface = $revisiInterface;
        $this->progressInterface = $progressInterface;
    }

    public function simpanRevisi(array $data, $route)
    {
        $revisi = $this->revisiInterface->create([
            'id_peserta' => auth()->user()->peserta->id,
            'id_route' => $route
        ]);

        foreach ($data['progress'] as $progress) {
            $this->progressInterface->create([
                'id_revisi' => $revisi->id,
                'deskripsi' => $progress
            ]);
        }

        return Api::response(
            $revisi,
            'Berhasil mengirimkan revisi',
        );
    }

    public function getRevisi($id)
    {
        return $this->revisiInterface->find($id);
    }

    public function updateRevisi($id, array $data)
    {
        $progressItems = $this->progressInterface->findByRevisi($id);

        if ($progressItems->isEmpty()) {
            return Api::response(null, 'Progress tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $updateMap = collect($data['progress'])->keyBy('id');

        $updatedStatus = [];

        foreach ($progressItems as $progress) {
            if ($updateMap->has($progress->id)) {
                $newStatus = $updateMap[$progress->id]['status'];
                $updatedStatus[] = $newStatus;

                if ($progress->status != $newStatus) {
                    $this->progressInterface->update($progress->id, [
                        'status' => $newStatus
                    ]);
                }
            } else {
                $updatedStatus[] = $progress->status;
            }
        }

        $allCompleted = collect($updatedStatus)->every(fn($status) => $status == true);

        if ($allCompleted) {
            $this->revisiInterface->update($id, ['status' => true]);
        }

        return Api::response(null, 'Berhasil mengupdate revisi');
    }

}
