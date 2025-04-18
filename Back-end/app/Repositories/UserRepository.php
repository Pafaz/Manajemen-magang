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

    public function find(string $email): ? User
    {
        return User::where('email' , $email)->first();
    }

    public function findId(string $id): ? User
    {
        return User::where('id' , $id)->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(string $id, array $data): User
    {

        return tap(User::findOrFail($id))->update($data);
    }

    public function delete(int $id): void
    {
        User::findOrFail($id)->delete();
    }
}
