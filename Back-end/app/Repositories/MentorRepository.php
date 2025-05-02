<?php

namespace App\Repositories;

use App\Interfaces\MentorInterface;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Collection;

class MentorRepository implements MentorInterface
{
    public function getAll($id = null): Collection
    {
        return Mentor::all();
    }

    public function find($id): ?Mentor
    {
        return Mentor::findOrFail($id)->first();
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
}