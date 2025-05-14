<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'surat.penerimaan', [
    'perusahaan'=> 'PT. Elang Jaya',
    'alamat_perusahaan'=> 'Banyuwangi',
    'telepon_perusahaan'=> '082192813',
    'email_perusahaan'=> 'elang',
    'website_perusahaan'=> 'www.google.com',
    'no_surat'=> '123',
    'sekolah'=> 'Poliwangi',
    'tanggal_mulai'=> '12 Juni 2025',
    'tanggal_selesai'=> '16 Juni 2025',
    'peserta'=> 'Elang',
    'no_identitas'=> '77183618313',
    'penanggung_jawab' => 'Afif',
    'jabatan_pj'=> 'HRD',
]);
