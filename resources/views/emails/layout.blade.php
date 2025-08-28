<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '7PLAY - Platform Pemesanan Tiket Bioskop' }}</title>
    <style>
        @import url('https://fonts.bunny.net/css?family=poppins:300,400,500,600,700');
        
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            background: linear-gradient(135deg, #ffffff 0%, #dbeafe 50%, #bfdbfe 100%);
            margin: 0;
            padding: 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            padding: 40px 20px;
            text-align: center;
        }
        
        .email-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            filter: brightness(0) invert(1);
        }
        
        .email-header h1 {
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .email-header p {
            color: #dbeafe;
            font-size: 16px;
            margin: 8px 0 0 0;
            font-weight: 400;
        }
        
        /* Content */
        .email-content {
            padding: 40px 32px;
        }
        
        .email-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 16px;
            text-align: center;
        }
        
        .email-text {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        
        .email-text strong {
            color: #1f2937;
            font-weight: 600;
        }
        
        /* Button */
        .email-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff !important;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
            transition: all 0.3s ease;
            margin: 24px 0;
            min-width: 200px;
        }
        
        .email-button:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(59, 130, 246, 0.5);
        }
        
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        
        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
        }
        
        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #1e40af;
            line-height: 1.5;
        }
        
        /* Warning Box */
        .warning-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
        }
        
        .warning-box p {
            margin: 0;
            font-size: 14px;
            color: #92400e;
            line-height: 1.5;
        }
        
        /* Footer */
        .email-footer {
            background: #f8fafc;
            padding: 32px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer-content {
            margin-bottom: 24px;
        }
        
        .footer-content h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }
        
        .footer-legal {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer-legal p {
            margin: 4px 0;
        }
        
        .footer-legal a {
            color: #6b7280;
            text-decoration: none;
        }
        
        .footer-legal a:hover {
            color: #3b82f6;
        }
        
        /* Code/Token Display */
        .code-display {
            background: #f8fafc;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 24px 0;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        }
        
        .code-display .code {
            font-size: 24px;
            font-weight: 700;
            color: #1d4ed8;
            letter-spacing: 4px;
            margin: 8px 0;
            user-select: all;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-header {
                padding: 30px 16px;
            }
            
            .email-header h1 {
                font-size: 28px;
            }
            
            .email-content {
                padding: 32px 20px;
            }
            
            .email-footer {
                padding: 24px 20px;
            }
            
            .email-button {
                display: block;
                margin: 24px 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div style="padding: 20px 0;">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <img src="{{ asset('storage/logo.svg') }}" alt="7PLAY Logo">
                <h1>7PLAY</h1>
                <p>Platform Pemesanan Tiket Bioskop Terpercaya</p>
            </div>
            
            <!-- Content -->
            <div class="email-content">
                @yield('content')
            </div>
            
            <!-- Footer -->
            <div class="email-footer">
                <div class="footer-content">
                    <h3>Butuh Bantuan?</h3>
                    <p style="color: #6b7280; font-size: 14px; margin: 8px 0;">
                        Tim customer service kami siap membantu Anda 24/7
                    </p>
                    
                    <div class="social-links">
                        <a href="mailto:support@7play.id">Email Support</a>
                        <a href="https://wa.me/628111234567">WhatsApp</a>
                        <a href="tel:+62215551234">Telepon</a>
                    </div>
                </div>
                
                <div class="footer-legal">
                    <p>&copy; {{ date('Y') }} 7PLAY. Seluruh hak cipta dilindungi.</p>
                    <p>
                        <a href="{{ url('/terms') }}">Syarat & Ketentuan</a> | 
                        <a href="{{ url('/privacy') }}">Kebijakan Privasi</a> | 
                        <a href="{{ url('/help') }}">Pusat Bantuan</a>
                    </p>
                    <p style="margin-top: 12px;">
                        PT 7PLAY Indonesia<br>
                        Menara BCA, Lantai 45, Jl. M.H. Thamrin No.1<br>
                        Jakarta Pusat 10310, Indonesia
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
