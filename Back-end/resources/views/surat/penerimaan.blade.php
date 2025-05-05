<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Penerimaan PKL</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; line-height: 1.6; }
        .header, .footer { text-align: center; }
        .content { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <p>Nomor: {{ $nomor }}</p>
        <p>Lamp. : -</p>
        <p>Perihal: Praktek Kerja Lapangan</p>
    </div>

    <div class="content">
        <p>Kepada Yth:</p>
        <p>{{ $sekolah }}</p>
        <p>{{ $alamat_sekolah }}</p>

        <p>Dengan hormat,</p>

        <p>
            Menindaklanjuti surat permohonan Praktek Kerja Lapangan yang Bapak/Ibu ajukan, 
            bersama ini kami menyatakan bahwa dapat MENERIMA siswa {{ $sekolah }} untuk 
            melaksanakan PKL di {{ $nama_perusahaan }} pada tanggal 
            {{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }} 
            - {{ \Carbon\Carbon::parse($tanggal_selesai)->translatedFormat('d F Y') }}.
        </p>

        <p>Adapun nama siswa tersebut adalah sebagai berikut:</p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Nomor Induk / NIM</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peserta as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ $item['nim'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>
            Demikian surat ini kami sampaikan dan atas kerja samanya kami ucapkan terima kasih.
        </p>

        <br><br>
        <p>Hormat kami,</p>
        <p>{{ $nama_perusahaan }}</p>
        <br><br>
        <p><strong>{{ $penandatangan }}</strong></p>
        <p>{{ $jabatan }}</p>
    </div>
</body>
</html>
