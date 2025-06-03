<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Peringatan Kerja</title>
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
            background-image: url('{{ public_path("images/kop.png") }}');
            background-size: cover;
            background-position: center;
            background-color: #00b8e6;
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
            background-color: #00b8e6;
            color: white;
            text-align: center;
            padding: 8px;
            font-size: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        /* Untuk print/PDF */
        @media print {
            .page-footer {
                position: absolute;
            }
        }

        /* Reset table borders */
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
                        <img src="{{ public_path('images/logo.png') }}" alt="Logo Perusahaan">
                    </div>
                </td>
                <td class="company-info">
                    <div class="company-name">{{ $perusahaan }}</div>
                    <div class="company-address">{{ $alamat_perusahaan }}</div>
                    <div class="contact-info">
                        <div>Telp: {{ $no_telepon }}</div>
                        <div>Email: {{ $email }}</div>
                        <div>Web: {{ $website }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <div class="surat-header">
            <p>Nomor : {{ $no_surat }}</p>
            <p>Lamp. : -</p>
            <p>Perihal : <strong>Surat Peringatan Kerja</strong></p>
        </div>

        <p>Dengan hormat,</p>
        
        <p>Dengan ini kami beritahukan jika kami sudah memutuskan untuk memberikan <strong>{{ $keterangan_surat }}</strong> kepada <strong>{{ $nama }}</strong> Asal {{ $sekolah }}, pada tanggal {{ $tanggal }}.</p>

        <p>Keputusan ini terpaksa kami ambil setelah mempertimbangkan banyak hal, di antaranya: yang bersangkutan telah melanggar peraturan yang telah diterapkan oleh perusahaan yaitu {{ $alasan }}. Kami berharap agar yang bersangkutan bisa menerima dan memaklumi keputusan ini dan jika mengulangi kembali harus bersedia untuk dikembalikan dan diberhentikan sebagai peserta magang di {{ $perusahaan }}.</p>

        <p>Demikian surat peringatan kerja ini kami sampaikan, atas perhatian dan kerjasamanya, kami ucapkan terimakasih.</p>
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
                    <strong>{{ $nama_penanggung_jawab }}</strong><br>
                    {{ $jabatan_penanggung_jawab }}
                </td>
            </tr>
        </table>
    </div>

    <div class="page-footer">
        &copy; {{ $perusahaan }} - {{ $tahun }}
    </div>
</body>
</html>