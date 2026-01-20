<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        /* General Resets */
        body {
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
        }
        table {
            border-spacing: 0;
            width: 100%;
        }
        td {
            padding: 0;
        }
        img {
            border: 0;
            max-width: 100%;
        }
        a {
            text-decoration: none;
            color: #059669; /* Green-600 */
        }

        /* Container */
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f7f9fc;
            padding-bottom: 40px;
        }

        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            font-family: sans-serif;
            color: #171717;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        /* Header */
        .header {
            background-color: #ffffff;
            padding: 24px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #059669; /* Green-600 */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Body */
        .body-content {
            padding: 32px 24px;
            background-color: #ffffff;
        }

        /* Footer */
        .footer {
            background-color: #111827; /* Gray-900 */
            color: #9ca3af; /* Gray-400 */
            padding: 32px 24px;
            font-size: 13px;
        }
        .footer h3 {
            color: #ffffff;
            font-size: 16px;
            margin-bottom: 12px;
            margin-top: 0;
        }
        .footer p {
            margin: 8px 0;
            color: #9ca3af;
        }
        .footer a {
            color: #10b981; /* Green-500 */
        }
        .footer .social-icons {
            margin: 20px 0;
            text-align: center;
        }
        .footer .social-icons a {
            display: inline-block;
            margin: 0 8px;
            font-weight: bold;
            font-size: 14px;
        }
        .divider {
            border-top: 1px solid #374151; /* Gray-700 */
            margin: 20px 0;
        }
        .disclaimer {
            font-size: 11px;
            color: #6b7280; /* Gray-500 */
            line-height: 1.4;
            text-align: center;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #059669; /* Green-600 */
            color: #ffffff !important;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            margin: 16px 0;
        }
        .btn:hover {
            background-color: #047857;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" width="100%" cellpadding="0" cellspacing="0">
            <!-- Header -->
            <tr>
                <td class="header">
                    <div class="logo-text">Trade Like Okafor</div>
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td class="body-content">
                    @yield('content')
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer">
                    <table width="100%">
                        <tr>
                            <td align="center" style="padding-bottom: 24px;">
                                <h3>Contact Us</h3>
                                <p>Call: <a href="tel:{{ \App\Models\Setting::where('key', 'support_phone')->value('value') ?? '+2348157841450' }}">{{ \App\Models\Setting::where('key', 'support_phone')->value('value') ?? '+2348157841450' }}</a></p>
                                <p>Email: <a href="mailto:{{ \App\Models\Setting::where('key', 'support_email')->value('value') ?? 'support@tradelikeokafor.com' }}">{{ \App\Models\Setting::where('key', 'support_email')->value('value') ?? 'support@tradelikeokafor.com' }}</a></p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding-bottom: 24px;">
                                <h3>Visit Our Office</h3>
                                <p style="max-width: 300px; margin: 0 auto; line-height: 1.5;">
                                    {!! nl2br(e(\App\Models\Setting::where('key', 'address')->value('value') ?? "Block 1 plot 8 Memunat ayodeji crescent,\nEtal Ave, Ikeja Lagos NG, Oregun, Ikeja 100271, Lagos, Nigeria.")) !!}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="social-icons">
                                <a href="{{ \App\Models\Setting::where('key', 'telegram_url')->value('value') ?? '#' }}">Telegram</a>
                                <a href="{{ \App\Models\Setting::where('key', 'instagram_url')->value('value') ?? '#' }}">Instagram</a>
                                <a href="{{ \App\Models\Setting::where('key', 'youtube_url')->value('value') ?? '#' }}">YouTube</a>
                                <a href="{{ \App\Models\Setting::where('key', 'tradingview_url')->value('value') ?? '#' }}">TradingView</a>
                            </td>
                        </tr>
                        <tr>
                             <td class="disclaimer">
                                <div class="divider"></div>
                                <p><strong>Disclaimer:</strong> This email contains strictly Educational materials for Leverage Trading. No form of Solicitation or other guarantee is intended. Trading and/or investing in Leveraged Products comes with a substantial amount of risk and you may lose part or all of your investments. Be Advised.</p>
                                <p style="margin-top: 12px;">© {{ date('Y') }} Trade Like Okafor. All rights reserved.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
