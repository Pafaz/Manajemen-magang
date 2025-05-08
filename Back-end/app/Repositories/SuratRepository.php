<?php

namespace App\Repositories;

use App\Interfaces\SuratInterface;
use App\Models\Surat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SuratRepository implements SuratInterface
{

    public function getAll(): Collection
    {
        return Surat::all();
    }

    public function find($id): ?Surat
    {
        return Surat::findOrFail($id);
    }

    public function findByPeserta($id_peserta): ?Surat
    {
        return Surat::where("id_peserta", $id_peserta)->first();
    }

    public function create(array $data): ?Surat
    {
        return Surat::create($data);
    }

    public function update(int $id, array $data): mixed
    {
        $surat = Surat::findOrFail($id);
        $surat->update($data);
        return $surat;
    }

    public function delete(int $id): void
    {
        Surat::findOrFail($id)->delete();
    }

    public function query(): Builder
    {
        return Surat::query();
    }

    public function getAllByCabang(int $id_cabang, ?string $jenis = null, bool $withPeserta = true): Collection
    {
        $query = $this->query()->where('id_cabang', $id_cabang);
        
        if ($jenis) {
            $query->where('jenis', $jenis);
        }
        
        if ($withPeserta) {
            $query->with(['peserta.user' => function($query){
                $query->select('id', 'nama');
            }]);
            $query->with(['peserta.foto' => function($query){
                $query->where('type', 'profile');
            }]);
        }

        if ($jenis == 'penerimaan') {
            $query->with(['peserta.magang' => function($query) {
                $query->select('id', 'id_peserta', 'mulai', 'selesai', 'status')->where('status', 'diterima');
            }]);
        }
        
        return $query->get();
    }

    public function getAllByPeserta(int $id_peserta, ?string $jenis = null): Collection
    {
        $query = $this->query()->where('id_peserta', $id_peserta);
        
        if ($jenis) {
            $query->where('jenis', $jenis);
        }
        
        return $query->get();
    }

    public function getStatsByCabang(int $id_cabang): array
    {
        return [
            'total' => $this->query()->where('id_cabang', $id_cabang)->count(),
            'penerimaan' => $this->query()
                ->where('id_cabang', $id_cabang)
                ->where('jenis', 'penerimaan')
                ->count(),
            'peringatan' => $this->query()
                ->where('id_cabang', $id_cabang)
                ->where('jenis', 'peringatan')
                ->count(),
        ];
    }
}