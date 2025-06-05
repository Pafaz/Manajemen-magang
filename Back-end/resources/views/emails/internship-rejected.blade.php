<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Status Pendaftaran</title>
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
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .info-icon {
            text-align: center;
            font-size: 50px;
            color: #ff6b6b;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #fff5f5;
            border-left: 4px solid #ff6b6b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
        .encouragement-box {
            background-color: #f0f8ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
        .reason-box {
            background-color: #fff9e6;
            border-left: 4px solid #ffa726;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Update Status Pendaftaran Magang</h1>
        </div>
        
        <div class="content">
            <div class="info-icon">📄</div>
            
            <h2>Halo {{ $userName }},</h2>
            
            <p>Terima kasih atas minat Anda untuk bergabung dalam program magang kami. Setelah melalui proses seleksi yang ketat, kami ingin memberitahukan status aplikasi Anda.</p>
            
            <div class="info-box">
                <h3>📋 Detail Pendaftaran:</h3>
                <p><strong>🏢 Perusahaan:</strong> {{ $companyName }}</p>
                <p><strong>💼 Posisi:</strong> {{ $position }}</p>
                <p><strong>📅 Tanggal Daftar:</strong> {{ $appliedDate }}</p>
                <p><strong>📊 Status:</strong> <span style="color: #ff6b6b; font-weight: bold;">Belum dapat diterima saat ini</span></p>
            </div>

            @if($rejectionReason)
            <div class="reason-box">
                <h3>💬 Catatan dari Tim Rekrutmen:</h3>
                <p>{{ $rejectionReason }}</p>
            </div>
            @endif
            
            <div class="encouragement-box">
                <h3>💪 Jangan Berkecil Hati!</h3>
                <p>Keputusan ini tidak mengurangi potensi dan kemampuan Anda. Kami mendorong Anda untuk:</p>
                <ul>
                    <li>Terus mengembangkan skill dan kemampuan</li>
                    <li>Mencoba kesempatan magang lainnya</li>
                    <li>Mendaftar kembali di periode mendatang</li>
                    <li>Bergabung dengan komunitas alumni untuk networking</li>
                </ul>
            </div>
            
            <h3>🚀 Kesempatan Lainnya:</h3>
            <ul>
                <li>Pantau terus website kami untuk lowongan magang terbaru</li>
                <li>Ikuti webinar dan workshop gratis yang kami selenggarakan</li>
                <li>Berlangganan newsletter untuk update terbaru</li>
                <li>Hubungi tim career support untuk konsultasi karir</li>
            </ul>
            
            <p>Kami sangat menghargai waktu dan usaha yang telah Anda investasikan dalam proses aplikasi ini.</p>
            
            <center>
                <a href="#" class="button">Lihat Lowongan Lain</a>
                <a href="#" class="button" style="background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);">Career Support</a>
            </center>
        </div>
        
        <div class="footer">
            <p>Tetap semangat dan jangan pernah berhenti untuk bermimpi!</p>
            <p><strong>Tim {{ config('app.name') }}</strong></p>
            <p>Kami yakin kesempatan terbaik sedang menanti Anda di masa depan.</p>
        </div>
    </div>
</body>
</html>