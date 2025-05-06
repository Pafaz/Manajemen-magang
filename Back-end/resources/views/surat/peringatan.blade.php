<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Penerimaan Magang</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.5;
            width: 210mm;
            height: 297mm;
            position: relative;
            box-sizing: border-box;
        }
        
        .header {
            padding: 20px;
            display: flex;
            align-items: center;
            height: 130px;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }
        
        .header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        
        .logo {
            width: 100px;
            height: 100px;
            position: relative;
            z-index: 1;
        }
        
        .company-info {
            margin-left: 20px;
            color: white;
            text-align: right;
            flex-grow: 1;
            position: relative;
            z-index: 1;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .company-address {
            font-size: 14px;
            max-width: 500px;
            margin-left: auto;
        }
        
        .contact-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            color: white;
            font-size: 14px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }
        
        .contact-icon {
            margin-right: 5px;
            font-size: 16px;
        }
        
        .content {
            padding: 20px 30px;
            height: calc(297mm - 130px - 30px);
            box-sizing: border-box;
            position: relative;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
        }
        
        .footer {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-right: 30px;
            margin-top: 40px;
            position: absolute;
            bottom: 50px;
            right: 0;
        }
        
        .signature {
            text-align: center;
            margin-top: 10px;
        }
        
        .qrcode {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }
        
        .page-footer {
            background-color: #00b8e6;
            height: 30px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        
        @media print {
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
            }
            
            .header, .content, .footer, .page-footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Gambar Header -->
        <img src="/assets/img/banner/kopsurat.png" alt="Header Background" class="header-bg">
        
        <div class="logo">
            <!-- Logo perusahaan bisa diletakkan di sini -->
            <img src="/assets/logo" alt="Logo Perusahaan">
        </div>
        <div class="company-info">
            <div class="company-name">{{ $nama_perusahaan }}</div>
            <div class="company-address">{{ $alamat_perusahaan }}</div>
            <div class="contact-info">
                <div class="contact-item">
                    <span class="contact-icon">📞</span> {{ $no_telepon }}
                </div>
                <div class="contact-item">
                    <span class="contact-icon">✉️</span> {{ $email }}
                </div>
                <div class="contact-item">
                    <span class="contact-icon">🌐</span> {{ $website }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <p style="margin-top: 20px; margin-bottom: 8px;">Nomor : 316/PKL/HMTI/2025</p>
        <p style="margin-top: 0; margin-bottom: 8px;">Lamp. : -</p>
        <p style="margin-top: 0; margin-bottom: 20px;">Perihal : <strong>Praktek Kerja Lapangan</strong></p>
        
        <p style="margin-bottom: 8px;">Kepada Yth:<br>
        {{ $mitra }}<br>
        {{ $alamat_mitra }}<br>
        Telp. {{ $telepon_perusahaan }}</p>
        
        <p>Dengan hormat,</p>
        
        <p>Menindaklanjuti surat permohonan Praktek Kerja Lapangan yang Bapak/Ibu ajukan, bersama ini kami menyatakan bahwa dapat MENERIMA siswa {{ $mitra }} untuk melaksanakan PKL di {{ $nama_perusahaan }} pada tanggal {{ $tanggal_mulai }} - {{ $tanggal_selesai }}. Adapun nama siswa tersebut adalah sebagai berikut:</p>
        
        <table>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Nomer Induk/NIM</th>
            </tr>
            <tr>
                <td>1</td>
                <td>{{ $nama_peserta }}</td>
                <td>{{ $no_identitas }}</td>
            </tr>
        </table>
        
        <p>Demikian surat ini kami sampaikan dan atas kerja samanya kami mengucapkan terima kasih.</p>
        
        <div class="footer">
            <div class="company-sign">{{ $nama_perusahaan }}</div>
            <div class="qrcode">
                <img src="/assets/img/barcode.png" alt="Header Background" class="header-bg">
            </div>
            <div class="signature">
                <strong>{{ $nama_penanggung_jawab }}</strong><br>
                {{ $jabatan_penanggung_jawab }}
            </div>
        </div>
    </div>
    
    <div class="page-footer"></div>
</body>
</html>