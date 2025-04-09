<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserInterface
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function find(int $id): ? User
    {
        return User::findOrFail($id)->first();
    }

    public function create(array $data): ? User
    {
        return User::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return User::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        User::findOrFail($id)->delete();
    }
}
