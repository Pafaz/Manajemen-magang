<?php

namespace Database\Factories;

use App\Models\Peserta;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesertaFactory extends Factory
{
    protected $model = Peserta::class;

    public function definition()
    {
        return [
            'id_user' => User::factory(),
            'id_jurusan' => Jurusan::factory(),
            'id_sekolah' => Sekolah::factory(),
            'nomor_identitas' => $this->faker->unique()->numerify('########'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'kelas' => $this->faker->word(),
            'alamat' => $this->faker->address(),
        ];
    }
}