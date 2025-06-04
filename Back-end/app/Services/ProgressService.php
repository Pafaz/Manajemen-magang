<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\ProgressInterface;

class ProgressService
{
    private ProgressInterface $progressInterface;

    public function __construct(ProgressInterface $progressInterface)
    {
        $this->progressInterface = $progressInterface;
    }

    public function updateProgress($id)
    {
        $data['status'] = 1;

        $progress = $this->progressInterface->update($id, $data);

        return Api::response(
            $progress,
            'progress telah selesai'
        );
    }

    public function deleteProgress($id)
    {
        $this->progressInterface->delete($id);

        return Api::response(
            null,
            'progress berhasil dihapus'
        );
    }
}