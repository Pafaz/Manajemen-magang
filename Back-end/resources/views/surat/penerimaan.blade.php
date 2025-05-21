<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Penerimaan Magang</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; color: #333; line-height: 1.5; width: 210mm; height: 297mm; position: relative; box-sizing: border-box;">
    <div style="padding: 20px; display: flex; align-items: center; height: 130px; box-sizing: border-box; position: relative; overflow: hidden;">
        <!-- Gambar Header -->
        <img src="{{ asset('images/kop.png') }}" alt="Header Background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
        
        <div style="width: 100px; height: 100px; position: relative; z-index: 1;">
            <!-- Logo perusahaan bisa diletakkan di sini -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan">
        </div>
        <div style="margin-left: 20px; color: white; text-align: right; flex-grow: 1; position: relative; z-index: 1;">
            <div style="font-size: 24px; font-weight: bold; margin-bottom: 5px;">{{ $perusahaan }}</div>
            <div style="font-size: 14px; max-width: 500px; margin-left: auto;">{{ $alamat_perusahaan }}</div>
            <div style="display: flex; justify-content: space-between; margin-top: 10px; color: white; font-size: 14px;">
                <div style="display: flex; align-items: center; margin: 0 10px;">
                    <span style="margin-right: 5px; font-size: 16px;">📞</span> {{ $telepon_perusahaan }}
                </div>
                <div style="display: flex; align-items: center; margin: 0 10px;">
                    <span style="margin-right: 5px; font-size: 16px;">✉️</span> {{ $email_perusahaan }}
                </div>
                <div style="display: flex; align-items: center; margin: 0 10px;">
                    <span style="margin-right: 5px; font-size: 16px;">🌐</span> {{ $website_perusahaan }}
                </div>
            </div>
        </div>
    </div>
    
    <div style="padding: 20px 30px; height: calc(297mm - 130px - 30px); box-sizing: border-box; position: relative;">
        <p style="margin-top: 20px; margin-bottom: 8px;">{{ $no_surat }}</p>
        <p style="margin-top: 0; margin-bottom: 8px;">Lamp. : -</p>
        <p style="margin-top: 0; margin-bottom: 20px;">Perihal : <strong>Praktek Kerja Lapangan</strong></p>
        
        <p style="margin-bottom: 8px;">Kepada Yth:<br>
        {{ $sekolah }}<br>
        
        <p>Dengan hormat,</p>
        
        <p>Menindaklanjuti surat permohonan Praktek Kerja Lapangan yang Bapak/Ibu ajukan, bersama ini kami menyatakan bahwa dapat MENERIMA siswa {{ $sekolah }} untuk melaksanakan PKL di {{ $perusahaan }} pada tanggal {{ $tanggal_mulai }} - {{ $tanggal_selesai }}. Adapun nama siswa tersebut adalah sebagai berikut:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">No</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Nama Lengkap</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Nomer Induk/NIM</th>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px;">1</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $peserta }}</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $no_identitas }}</td>
            </tr>
        </table>
        
        <p>Demikian surat ini kami sampaikan dan atas kerja samanya kami mengucapkan terima kasih.</p>
    </div>
    
    <div style="display: flex; flex-direction: column; align-items: flex-end; margin-right: 30px; margin-top: 40px; position: absolute; bottom: 50px; right: 0;">
        <div style="font-size: 14px; text-align: left; width: 40%;">{{ $perusahaan }}</div>
        <div style="width: 100px; height: 100px; margin-top: 10px; margin-left: 10px;">
            <img src="{{ asset('images/qrcode.jpeg') }}" alt="QR Code">
        </div>
        <div style="text-align: center; margin-top: 10px;">
            <strong>{{ $penanggung_jawab }}</strong><br>
            {{ $jabatan_pj }}
        </div>
    </div>

    <div style="background-color: #00b8e6; height: 30px; position: absolute; bottom: 0; width: 100%;"></div>
</body>
</html>
