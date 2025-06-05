<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Selamat! Anda Diterima</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px;
        }
        .celebration-icon {
            text-align: center;
            font-size: 60px;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #e8f5e8;
            border-left: 4px solid #4CAF50;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
        .contact-box {
            background-color: #f0f8ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 SELAMAT!</h1>
            <p>Anda telah diterima untuk program magang</p>
        </div>
        
        <div class="content">
            <div class="celebration-icon">🎊 🎈 🎉</div>
            
            <h2>Halo {{ $userName }}!</h2>
            
            <p>Kami dengan senang hati mengumumkan bahwa Anda telah <strong>DITERIMA</strong> untuk mengikuti program magang di perusahaan kami!</p>
            
            <div class="info-box">
                <h3>📋 Detail Magang Anda:</h3>
                <p><strong>🏢 Perusahaan:</strong> {{ $companyName }}</p>
                <p><strong>💼 Posisi:</strong> {{ $position }}</p>
                <p><strong>📅 Tanggal Mulai:</strong> {{ $startDate }}</p>
                <p><strong>📅 Tanggal Selesai:</strong> {{ $endDate }}</p>
                @if($address)
                    <p><strong>📍 Alamat:</strong> {{ $address }}</p>
                @endif
            </div>

            @if($contactPerson || $contactEmail || $contactPhone)
            <div class="contact-box">
                <h3>📞 Kontak Person:</h3>
                @if($contactPerson)
                    <p><strong>Nama:</strong> {{ $contactPerson }}</p>
                @endif
                @if($contactEmail)
                    <p><strong>Email:</strong> {{ $contactEmail }}</p>
                @endif
                @if($contactPhone)
                    <p><strong>Telepon:</strong> {{ $contactPhone }}</p>
                @endif
            </div>
            @endif

            @if($additionalInfo)
            <div class="highlight">
                <h3>ℹ️ Informasi Tambahan:</h3>
                <p>{{ $additionalInfo }}</p>
            </div>
            @endif
            
            <h3>📝 Hal yang Perlu Dipersiapkan:</h3>
            <ul>
                <li>Dokumen identitas (KTP/SIM)</li>
                <li>Surat keterangan sehat</li>
                <li>Pas foto terbaru (3x4)</li>
                <li>CV terbaru</li>
                <li>Surat pengantar dari institusi (jika diperlukan)</li>
            </ul>
            
            <p><strong>Catatan:</strong> Surat resmi penerimaan magang telah dilampirkan dalam email ini. Harap simpan dokumen tersebut sebagai bukti penerimaan.</p>
            
            <center>
                <a href="#" class="button">Dashboard Magang</a>
                <a href="#" class="button" style="background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);">Hubungi Support</a>
            </center>
        </div>
        
        <div class="footer">
            <p>Selamat bergabung dan semoga sukses dalam program magang!</p>
            <p><strong>Tim {{ config('app.name') }}</strong></p>
            <p>Jika ada pertanyaan, silakan hubungi kami kapan saja.</p>
        </div>
    </div>
</body>
</html>