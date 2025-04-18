<?php

namespace App\Repositories;

use App\Interfaces\MentorInterface;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Collection;

class MentorRepository implements MentorInterface
{
    public function getAll(): Collection
    {
        return Mentor::all();
    }

    public function find(int $id): ? Mentor
    {
        return Mentor::findOrFail($id)->first();
    }

    public function create(array $data): ? Mentor
    {
        return Mentor::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Mentor::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Mentor::findOrFail($id)->delete();
    }
}
