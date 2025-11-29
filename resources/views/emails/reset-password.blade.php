<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sistem Rekrutmen Asisten Lab</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="width: 100%; max-width: 600px; border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); padding: 40px 30px; text-align: center; border-radius: 16px 16px 0 0;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700;">
                                🎓 Sistem Rekrutmen Asisten Lab
                            </h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="background-color: #ffffff; padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 22px; font-weight: 600;">
                                Reset Password Anda
                            </h2>
                            
                            <p style="margin: 0 0 20px; color: #475569; font-size: 16px; line-height: 1.6;">
                                Halo,
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #475569; font-size: 16px; line-height: 1.6;">
                                Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah ini untuk membuat password baru:
                            </p>
                            
                            <!-- Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetLink }}" style="display: inline-block; padding: 16px 32px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; border-radius: 12px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);">
                                            Reset Password Sekarang
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 0 0 20px; color: #475569; font-size: 14px; line-height: 1.6;">
                                Atau salin link berikut ke browser Anda:
                            </p>
                            
                            <p style="margin: 0 0 20px; padding: 15px; background-color: #f8fafc; border-radius: 8px; word-break: break-all; color: #2563eb; font-size: 13px; border: 1px solid #e2e8f0;">
                                {{ $resetLink }}
                            </p>
                            
                            <div style="margin: 30px 0; padding: 20px; background-color: #fef3c7; border-radius: 12px; border-left: 4px solid #f59e0b;">
                                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.5;">
                                    <strong>⚠️ Penting:</strong> Link ini hanya berlaku selama <strong>1 jam</strong>. Jika Anda tidak meminta reset password, abaikan email ini.
                                </p>
                            </div>
                            
                            <p style="margin: 0; color: #475569; font-size: 16px; line-height: 1.6;">
                                Salam hangat,<br>
                                <strong>Tim Rekrutmen Asisten Lab</strong>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 30px; text-align: center; border-radius: 0 0 16px 16px; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 10px; color: #64748b; font-size: 14px;">
                                Email ini dikirim secara otomatis. Jangan membalas email ini.
                            </p>
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                © {{ date('Y') }} Sistem Rekrutmen Asisten Laboratorium. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
