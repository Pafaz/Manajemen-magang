<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\Surat;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Interfaces\UserInterface;
use App\Interfaces\RouteInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MagangInterface;
use App\Interfaces\MentorInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\InternshipAcceptedEmail;
use App\Mail\InternshipRejectedEmail;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\MagangResource;
use App\Mail\RegistrationSuccessEmail;
use App\Http\Resources\PesertaResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MagangDetailResource;
use Symfony\Component\HttpFoundation\Response;

class MagangService
{
    private MagangInterface $MagangInterface;
    private FotoService $foto;
    private SuratService $suratService;
    private UserInterface $userInterface;
    private MentorInterface $mentorInterface;
    private RouteInterface $routeInterface;
    public function __construct(
        MagangInterface $MagangInterface, 
        FotoService $foto, 
        UserInterface $userInterface, 
        SuratService $suratService, 
        MentorInterface $mentorInterface,
        RouteInterface $routeInterface)
    {
        $this->MagangInterface = $MagangInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
        $this->suratService = $suratService;
        $this->mentorInterface = $mentorInterface;
        $this->routeInterface = $routeInterface;
    }

    public function getAllPesertaMagang()
    {
        $id = auth('sanctum')->user()->id_cabang_aktif;
        $cacheKey = 'magang_cabang_'. $id;
        $data = Cache::remember($cacheKey, 3600, function () use ($id) {
            return $this->MagangInterface->getAll($id);
        });

        return Api::response(
            MagangResource::collection($data),
            'Berhasil mendapatkan data peserta magang', 
        );
    }

    public function getMagangbyId($id){
        $cacheKey = 'magang_detail_'. $id;
        $data = Cache::remember($cacheKey, 360, function () use ($id) {
            return $this->MagangInterface->find($id);
        });

        return Api::response(
            new MagangDetailResource($data),
            'Berhasil mendapatkan data magang',
        );
    }

    public function countPendaftar($lowonganId)
    {
        return $this->MagangInterface->countPendaftar($lowonganId);
    }

    public function applyMagang(array $data)
    {
        $user = auth('sanctum')->user();

        DB::beginTransaction();

        try {
            if (!$user->peserta) {
                Log::error('User ' . $user->id . ' mencoba mengajukan magang tanpa melengkapi data diri.');
                DB::rollback();
                return Api::response(null, 'Silahkan lengkapi data diri terlebih dahulu', Response::HTTP_FORBIDDEN);
            }

            if ($this->MagangInterface->alreadyApply($user->peserta->id, $data['id_lowongan'])) {
                Log::warning('User ' . $user->id . ' sudah mengajukan magang di lowongan ' . $data['id_lowongan']);
                DB::rollback();
                return Api::response(null, 'Anda sudah mengajukan magang di lowongan ini', Response::HTTP_FORBIDDEN);
            }

            $magang = $this->MagangInterface->create([
                'id_peserta' => $user->peserta->id,
                'id_lowongan' => $data['id_lowongan'],
                'mulai' => $data['mulai'],
                'selesai' => $data['selesai'],
                'status' => 'menunggu',
            ]);

            $cacheKey = 'magang_cabang_' . auth('sanctum')->user()->id_cabang_aktif;
            Cache::forget($cacheKey);

            if (!empty($data['surat_pernyataan_diri'])) {
                $this->foto->updateFoto($data['surat_pernyataan_diri'], $magang->id, 'surat_pernyataan_diri', 'magang');
            }
            DB::commit();
            
            Log::info('User ' . $user->id . ' berhasil mengajukan magang di lowongan ' . $data['id_lowongan']);

            $dataMagang = $this->MagangInterface->findByPesertaAndCabang($user->id, $user->id_cabang_aktif);

            $this->sendRegistrationSuccess($user, $dataMagang);

            return Api::response(
                MagangDetailResource::make($magang),
                'Berhasil mengajukan magang',
                Response::HTTP_CREATED
            );

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Terjadi kesalahan saat mengajukan magang: ' . $e->getMessage());
            
            return Api::response(null, 'Terjadi kesalahan saat mengajukan magang', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }  

    public function approvalMagang(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            $magang = $this->MagangInterface->find($id);

            if (!in_array($data['status'], ['diterima', 'ditolak'])) {
                return Api::response(null, 'Status tidak valid', Response::HTTP_BAD_REQUEST);
            }

            if ($magang->status == $data['status']) {
                return Api::response(null, 'Status sudah sesuai', Response::HTTP_OK);
            }

            $magang->status = $data['status'];
            $magang->id_divisi = $magang->lowongan->id_divisi;

            $magang->save();

            $cacheKeys = [
                    'magang_cabang_' . auth('sanctum')->user()->id_cabang_aktif,
                    'peserta_cabang_' . auth('sanctum')->user()->id_cabang_aktif,
                    'magang_detail_' . $id
            ];

            array_map(fn($key) => Cache::forget($key), $cacheKeys);

            $dataSurat = [
                'id_peserta' => $magang->peserta->id,
                'id_cabang' => $magang->lowongan->cabang->id,
                'id_perusahaan' => $magang->lowongan->perusahaan->id,
                'perusahaan' => $magang->lowongan->perusahaan->user->nama,
                'alamat_perusahaan' => $magang->lowongan->perusahaan->alamat,
                'telepon_perusahaan' => $magang->lowongan->perusahaan->user->telepon,
                'email_perusahaan' => $magang->lowongan->perusahaan->user->email,
                'website_perusahaan' => $magang->lowongan->perusahaan->website,
                'sekolah' => $magang->peserta->sekolah,
                'tanggal_mulai' => $magang->mulai,
                'tanggal_selesai' => $magang->selesai,
                'peserta'=> $magang->peserta->user->nama,
                'no_identitas' => $magang->peserta->nomor_identitas,
                'penanggung_jawab' => $magang->lowongan->perusahaan->nama_penanggung_jawab,
                'jabatan_pj'=> $magang->lowongan->perusahaan->jabatan_penanggung_jawab,
            ];

            if ($data['status'] == 'ditolak') {
                $this->sendRejectionNotification($magang->peserta->user, $magang);
                $magang->delete();
                $message = 'Berhasil menolak magang';
            } else {
                $message = 'Berhasil menyetujui magang';
                $this->userInterface->update($magang->peserta->user->id, ['id_cabang_aktif' => $magang->lowongan->id_cabang]);
                $dataSurat = $this->suratService->createSurat($dataSurat, 'penerimaan');
                $this->sendAcceptanceNotification($magang->peserta->user, $magang, $dataSurat);
            }

            DB::commit();

            return Api::response(
                MagangResource::make($magang),
                $message,
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing approval: ' . $e->getMessage());
            return Api::response(null, 'Terjadi kesalahan, silakan coba lagi', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function approveMany(array $ids, string $status)
    {
        DB::beginTransaction();

        try {
            $results = [];

            foreach ($ids as $id) {
                $magang = $this->MagangInterface->find($id);

                if (!$magang) {
                    $results[] = ['id' => $id, 'status' => 'gagal', 'alasan' => 'Data tidak ditemukan'];
                    continue;
                }

                if (!in_array($status, ['diterima', 'ditolak'])) {
                    $results[] = ['id' => $id, 'status' => 'gagal', 'alasan' => 'Status tidak valid'];
                    continue;
                }

                if ($magang->status == $status) {
                    $results[] = ['id' => $id, 'status' => 'gagal', 'alasan' => 'Status sudah sesuai'];
                    continue;
                }

                $magang->status = $status;
                $magang->id_divisi = $magang->lowongan->id_divisi;
                $magang->save();

                $cacheKeys = [
                    'magang_cabang_' . auth('sanctum')->user()->id_cabang_aktif,
                    'peserta_cabang_' . auth('sanctum')->user()->id_cabang_aktif,
                    'magang_detail_' . $id
                ];

                array_map(fn($key) => Cache::forget($key), $cacheKeys);

                $id_peserta = $magang->peserta->user->id;
                $this->userInterface->update($id_peserta, ['id_cabang_aktif' => $magang->lowongan->id_cabang]);

                if ($status === 'ditolak') {
                    $magang->delete();
                } else {
                    $dataSurat = [
                        'id_peserta' => $magang->peserta->id,
                        'id_cabang' => $magang->lowongan->cabang->id,
                        'id_perusahaan' => $magang->lowongan->perusahaan->id,
                        'perusahaan' => $magang->lowongan->perusahaan->user->nama,
                        'alamat_perusahaan' => $magang->lowongan->perusahaan->alamat,
                        'telepon_perusahaan' => $magang->lowongan->perusahaan->user->telepon,
                        'email_perusahaan' => $magang->lowongan->perusahaan->user->email,
                        'website_perusahaan' => $magang->lowongan->perusahaan->website,
                        'sekolah' => $magang->peserta->sekolah,
                        'tanggal_mulai' => $magang->mulai,
                        'tanggal_selesai' => $magang->selesai,
                        'peserta'=> $magang->peserta->user->nama,
                        'no_identitas' => $magang->peserta->nomor_identitas,
                        'penanggung_jawab' => $magang->lowongan->perusahaan->nama_penanggung_jawab,
                        'jabatan_pj'=> $magang->lowongan->perusahaan->jabatan_penanggung_jawab,
                    ];

                    $this->suratService->createSurat($dataSurat, 'penerimaan');
                }

                $results[] = ['id' => $id, 'status' => 'sukses'];
            }

            DB::commit();

            return Api::response($results, 'Batch approval selesai', Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(null, 'Terjadi kesalahan: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function setMentor($id_mentor, $pesertas)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        
        $mentor = $this->mentorInterface->findByIdCabang($id_mentor, $id_cabang);
        if (!$mentor) {
            return Api::response(null, 'Mentor tidak ditemukan di cabang ini', Response::HTTP_NOT_FOUND);
        }

        $mentorDivisi = $mentor->id_divisi;

        $kategoriPertama = $mentor->divisi->kategori->sortBy('pivot.urutan')->first();

        if (!$kategoriPertama) {
            return Api::response(null, 'Divisi tidak memiliki kategori proyek', Response::HTTP_BAD_REQUEST);
        }

        $invalidPesertas = collect($pesertas)->filter(function ($id_peserta) use ($id_cabang, $mentorDivisi) {
            $peserta = $this->MagangInterface->findByPesertaAndCabang($id_peserta, $id_cabang);
            return !$peserta || $peserta->lowongan->id_divisi !== $mentorDivisi;
        })->values()->all();

        if (count($invalidPesertas) > 0) {
            return Api::response([
                'invalid_pesertas' => $invalidPesertas
            ], 'Beberapa peserta tidak valid atau divisinya berbeda', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        foreach ($pesertas as $id_peserta) {
            $this->MagangInterface->updateByPesertaAndCabang($id_peserta, $id_cabang, [
                'id_mentor' => $id_mentor,
                'id_divisi' => $mentorDivisi
            ]);
            $this->routeInterface->markStarted($id_peserta, $kategoriPertama->id);
        }

        return Api::response(null, 'Mentor berhasil diatur & route awal diset untuk semua peserta', Response::HTTP_OK);
    }

    public function editDivisi($idPeserta, array $data)
    {
        $idCabang = auth('sanctum')->user()->id_cabang_aktif;

        $mentor = $this->mentorInterface->findByIdCabang($data['id_mentor'], $idCabang);
        if (!$mentor) {
            return Api::response(null, 'Mentor tidak ditemukan di cabang ini', Response::HTTP_NOT_FOUND);
        }

        $kategoriPertama = $mentor->divisi->kategori->sortBy('pivot.urutan')->first();

        $data = $this->MagangInterface->updateByPesertaAndCabang($idPeserta, $idCabang, [
            'id_divisi' => $data['id_divisi'],
            'id_mentor' => $data['id_mentor']
        ]);
        $this->routeInterface->markStarted($idPeserta, $kategoriPertama->id);

        return Api::response(
            null,
            'Divisi dan Mentor Peserta berhasil di update'
        );
    }

    private function sendRegistrationSuccess($user, $magang)
    {
        $internshipData = [
            'position' => $magang->lowongan->divisi->nama,
            'company' => $magang->lowongan->perusahaan->cabang->nama
        ];

        Mail::to($user->email)->send(new RegistrationSuccessEmail($user, $internshipData));
    }

    private function sendAcceptanceNotification($user, $magang, $pdfPath)
    {
        $internshipData = [
            'company_name' => $magang->lowongan->perusahaan->user->nama,
            'position' => $magang->lowongan->divisi->nama,
            'start_date' => $magang->mulai,
            'end_date' => $magang->selesai,
            'contact_person' => $magang->lowongan->perusahaan->nama_penanggung_jawab,
            'contact_email' => $magang->lowongan->perusahaan->email_penanggung_jawab,
            'contact_phone' => $magang->lowongan->perusahaan->user->telepon,
            'address' => $magang->lowongan->perusahaan->alamat,
            'additional_info' => '-',
        ];

        Mail::to($user->email)->send(new InternshipAcceptedEmail($user, $internshipData, $pdfPath));
    }

    private function sendRejectionNotification($user, $magang)
    {
        $internshipData = [
                'company_name' => $magang->lowongan->perusahaan->user->nama,
                'position' => $magang->divisi->nama,
                'applied_date' => $magang->mulai ? 
                    Carbon::parse($magang->mulai)->format('d M Y') : 
                    Carbon::now()->format('d M Y')
        ];

        $rejectionReason = 'Setelah melalui proses seleksi yang ketat, kami memutuskan untuk memilih kandidat lain yang lebih sesuai dengan kebutuhan posisi saat ini.';

        Mail::to($user->email)->send(new InternshipRejectedEmail($user, $internshipData, $rejectionReason));
    }
}