<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Perubahan Password</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 300;
        }

        .content {
            padding: 40px;
            color: #333333;
        }

        .icon {
            text-align: center;
            margin-bottom: 30px;
        }

        .icon svg {
            width: 64px;
            height: 64px;
            fill: #4CAF50;
        }

        .message {
            font-size: 16px;
            margin-bottom: 25px;
            text-align: center;
        }

        .details {
            background-color: #f9f9f9;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }

        .details h3 {
            margin-top: 0;
            color: #667eea;
            font-size: 16px;
        }

        .details p {
            margin: 8px 0;
            font-size: 14px;
        }

        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }

        .warning-box h3 {
            color: #856404;
            margin-top: 0;
            font-size: 16px;
        }

        .warning-box p {
            color: #856404;
            margin: 10px 0 0 0;
            font-size: 14px;
        }

        .action-button {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            display: inline-block;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer p {
            margin: 0;
            font-size: 12px;
            color: #6c757d;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }

            .header,
            .content,
            .footer {
                padding: 20px !important;
            }

            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🔐 Pemberitahuan Keamanan</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H9C7.9 1 7 1.9 7 3V9C7 10.1 7.9 11 9 11V13H8V15H9V21C9 22.1 9.9 23 11 23H13C14.1 23 15 22.1 15 21V15H16V13H15V11C16.1 11 17 10.1 17 9V3C17 1.9 16.1 1 15 1L21 7V9ZM15 9H9V3H15V9Z" />
                </svg>
            </div>

            <div class="message">
                <h2 style="color: #333; margin-bottom: 10px;">Password Anda Telah Berhasil Diubah</h2>
                <p>Kami menginformasikan bahwa password akun Anda telah berhasil diperbarui.</p>
            </div>

            <div class="details">
                <h3>Detail Perubahan:</h3>
                <p><strong>Waktu:</strong> <span id="datetime">{{ date('d m Y, h:i', strtotime($datetime)) }}</span>
                </p>
                <p><strong>IP Address:</strong> <span id="ip">{{ $ip_address }}</span></p>
                <p><strong>Perangkat:</strong> <span id="device">{{ $user_agent }}</span></p>
            </div>

            <div class="warning-box">
                <h3>⚠️ Jika Anda Tidak Melakukan Perubahan Ini</h3>
                <p>Segera hubungi tim dukungan kami dan ganti password Anda untuk menjaga keamanan akun.</p>
            </div>

            <div class="action-button">
                <a href="#" class="button">Hubungi Dukungan</a>
            </div>

            <div style="text-align: center; margin-top: 30px; font-size: 14px; color: #666;">
                <p><strong>Abaikan email ini jika Anda yang melakukan perubahan password.</strong></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                Email ini dikirim secara otomatis. Mohon jangan membalas email ini.<br>
                {{-- Jika Anda memiliki pertanyaan, silakan kunjungi <a href="#">Pusat Bantuan</a> kami. --}}
            </p>
            <p style="margin-top: 15px;">
                © 2025 E-hibah. Semua hak dilindungi.
            </p>
        </div>
    </div>

    <script>
        // Update datetime dengan waktu saat ini
        document.getElementById('datetime').textContent = new Date().toLocaleString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            timeZoneName: 'short'
        });
    </script>
</body>

</html>
