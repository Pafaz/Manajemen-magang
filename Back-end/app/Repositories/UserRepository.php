<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserInterface
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function getAdminByCabang(int $id): Collection
    {
        return User::where('id_cabang', $id)->get();
    }

    public function find(string $email): ? User
    {
        return User::where('email' , $email)->first();
    }

    public function findId(string $id): ? User
    {
        return User::findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function firstOrCreateByEmail(array $attributes, array $values): User
    {
        return User::firstOrCreate($attributes, $values);
    }

    public function update(string $id, array $data): User
    {

        return tap(User::findOrFail($id))->update($data);
    }

    public function delete($id): void
    {
        $user = User::find($id);
    
        if (!$user) {
            throw new \Exception('User not found');
        }
    
        // Log sebelum detach
        Log::info("Detaching roles for user ID: {$id}");
        $user->roles()->detach();
    
        // Log sebelum delete
        Log::info("Deleting user ID: {$id}");
        $user->delete();
    }
    
}
