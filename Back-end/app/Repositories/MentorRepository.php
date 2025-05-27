<?php

namespace App\Repositories;

use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MentorInterface;
use Illuminate\Database\Eloquent\Collection;

class MentorRepository implements MentorInterface
{
    public function getAll($id = null): Collection
    {
        return Mentor::all()->where('id_cabang', $id);
    }

    public function findByIdCabang($id_mentor, $id_cabang): ?Mentor
    {
        return Mentor::where('id', $id_mentor)  // Pertama pilih mentor berdasarkan ID
            ->where('id_cabang', $id_cabang)    // Filter berdasarkan id_cabang
            ->firstOrFail();  // Ambil hasil pertama yang ditemukan, atau gagal jika tidak ada
    }


    public function find($id): ?Mentor
    {
        $mentor = Mentor::findOrFail($id);
        return $mentor;
    }

    public function create(array $data): ?Mentor
    {
        return Mentor::create($data);
    }

    public function update($id, array $data): Mentor
    {
        $mentor = Mentor::findOrFail($id);
        $mentor->update($data);
        return $mentor;
    }

    public function delete($id): void
    {
        Mentor::findOrFail($id)->delete();
    }

    public function getMentorPerDivisi($id_cabang)
    {
        return Mentor::select('id_divisi', DB::raw('COUNT(*) as total'))
            ->where('id_cabang', $id_cabang)
            ->groupBy('id_divisi')
            ->with('divisi:id,nama')
            ->get();
    }
}
