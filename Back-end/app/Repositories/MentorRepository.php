<?php

namespace App\Repositories;

use App\Interfaces\MentorInterface;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Collection;

class MentorRepository implements MentorInterface
{
    public function getAll($id = null): Collection
    {
        return Mentor::all()->where('id_cabang', $id);
    }

    public function findByIdCabang($id_mentor, $id_cabang): ?Mentor
    {
        return Mentor::findOrFail( $id_mentor)->where('id_cabang', $id_cabang)->first();
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
        return $mentor->update($data);
    }

    public function delete($id): void
    {
        Mentor::findOrFail($id)->delete();
    }
}
