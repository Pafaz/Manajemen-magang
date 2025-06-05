<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Berhasil</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .success-icon {
            text-align: center;
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            margin-top: 20px;
            font-weight: bold;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Pendaftaran Berhasil!</h1>
        </div>
        
        <div class="content">
            <div class="success-icon">✅</div>
            
            <h2>Halo {{ $userName }}!</h2>
            
            <p>Selamat! Pendaftaran Anda untuk program magang telah berhasil disubmit dan sedang dalam proses review.</p>
            
            <div class="info-box">
                <h3>📋 Detail Pendaftaran:</h3>
                <p><strong>Email:</strong> {{ $userEmail }}</p>
                <p><strong>Tanggal Daftar:</strong> {{ $registrationDate }}</p>
                @if($internshipData)
                    <p><strong>Posisi:</strong> {{ $internshipData['position'] ?? 'Belum ditentukan' }}</p>
                    <p><strong>Perusahaan:</strong> {{ $internshipData['company'] ?? 'Belum ditentukan' }}</p>
                @endif
            </div>
            
            <h3>📝 Langkah Selanjutnya:</h3>
            <ul>
                <li>Tim kami akan mereview aplikasi Anda dalam 3-5 hari kerja</li>
                <li>Anda akan menerima email notifikasi untuk update status pendaftaran</li>
                <li>Pastikan email Anda aktif untuk menerima komunikasi lebih lanjut</li>
                <li>Siapkan dokumen pendukung yang mungkin diperlukan</li>
            </ul>
            
            <p>Jika ada pertanyaan, jangan ragu untuk menghubungi tim support kami.</p>
            
            <center>
                <a href="#" class="button">Dashboard Magang</a>
            </center>
        </div>
        
        <div class="footer">
            <p>Terima kasih telah memilih program magang kami!</p>
            <p><strong>Tim {{ config('app.name') }}</strong></p>
        </div>
    </div>
</body>
</html>