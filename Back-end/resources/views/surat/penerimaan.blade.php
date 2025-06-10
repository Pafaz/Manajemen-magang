<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Penerimaan Magang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
        }

        .header {
            background-color: #0069AB;
            padding: 15px;
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .header table {
            width: 100%;
            border: none;
        }

        .header td {
            border: none;
            padding: 5px;
            vertical-align: middle;
        }

        .logo-cell {
            width: 80px;
            text-align: left;
        }

        .logo {
            width: 60px;
            height: 60px;
        }

        .logo img {
            width: 100%;
            height: 100%;
        }

        .company-info {
            text-align: right;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-address {
            font-size: 11px;
            margin-bottom: 8px;
        }

        .contact-info {
            font-size: 10px;
        }

        .contact-info div {
            margin-bottom: 2px;
        }

        .content {
            padding: 0 30px;
            margin-bottom: 80px;
        }

        .content p {
            margin: 10px 0;
            text-align: justify;
        }

        .surat-header {
            margin-bottom: 20px;
        }

        .surat-header p {
            margin: 5px 0;
        }

        .footer-section {
            margin-top: 40px;
            text-align: right;
            padding-right: 30px;
        }

        .signature-table {
            float: right;
            text-align: center;
            border: none;
            width: 200px;
        }

        .signature-table td {
            border: none;
            padding: 5px;
            text-align: center;
        }

        .qrcode {
            width: 80px;
            height: 80px;
            margin: 10px auto;
        }

        .qrcode img {
            width: 100%;
            height: 100%;
        }

        .page-footer {
            background-color: #0069AB;
            color: white;
            text-align: center;
            padding: 8px;
            font-size: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        @media print {
            .page-footer {
                position: absolute;
            }
        }

        table {
            border-collapse: collapse;
        }

        .no-border {
            border: none !important;
        }

        .no-border td {
            border: none !important;
        }

        strong, b {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="no-border">
            <tr>
                <td class="logo-cell">
                    <div class="logo">
                        <img src="{{ $logo }}" alt="Logo Perusahaan">
                    </div>
                </td>
                <td class="company-info">
                    <div class="company-name">{{ $perusahaan }}</div>
                    <div class="company-address">{{ $alamat_perusahaan }}</div>
                    <div class="contact-info">
                        <div>Telp: {{ $telepon_perusahaan }}</div>
                        <div>Email: {{ $email_perusahaan }}</div>
                        <div>Web: {{ $website_perusahaan }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <div class="surat-header">
            <p>Nomor : {{ $no_surat }}</p>
            <p>Lamp. : -</p>
            <p>Perihal : <strong>Praktek Kerja Lapangan</strong></p>
        </div>

        <p>Dengan hormat,</p>

        <p>Menindaklanjuti surat permohonan Praktek Kerja Lapangan yang Bapak/Ibu ajukan, bersama ini kami menyatakan bahwa dapat MENERIMA siswa {{ $sekolah }} untuk melaksanakan PKL di {{ $perusahaan }} pada tanggal {{ $tanggal_mulai }} - {{ $tanggal_selesai }}. Adapun nama siswa tersebut adalah sebagai berikut:</p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">No</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Nama Lengkap</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Nomor Induk/NIM</th>
                </tr>
                @if (is_array($peserta) || $peserta instanceof \Illuminate\Support\Collection)
                        @foreach ($peserta as $index => $item)
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 10px;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid #ddd; padding: 10px;">{{ $item->user->nama }}</td>
                            <td style="border: 1px solid #ddd; padding: 10px;">{{ $item->nomor_identitas }}</td>
                        </tr>
                        @endforeach
                    
                @elseif (is_string($peserta)) 
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 10px;">1</td>
                            <td style="border: 1px solid #ddd; padding: 10px;">{{ $peserta }}</td>
                            <td style="border: 1px solid #ddd; padding: 10px;">{{ $no_identitas }}</td>
                        </tr>
                @else
                    <p>Error: Peserta tidak valid.</p>
                @endif
        </table>

        <p>Demikian surat ini kami sampaikan dan atas kerja samanya kami ucapkan terima kasih.</p>
    </div>

    <div class="footer-section">
        <table class="signature-table no-border">
            <tr>
                <td>{{ $perusahaan }}</td>
            </tr>
            <tr>
                <td>
                    <div class="qrcode">
                        <img src="{{ public_path('images/qrcode.jpeg') }}" alt="QR Code">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>{{ $penanggung_jawab }}</strong><br>
                    {{ $jabatan_pj }}
                </td>
            </tr>
        </table>
    </div>

    <div class="page-footer">
        &copy; {{ $perusahaan }} - 2025
    </div>
</body>
</html>
