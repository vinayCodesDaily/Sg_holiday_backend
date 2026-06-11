<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - SG Holidays</title>
</head>
<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial,Helvetica,sans-serif;color:#1a1a2e;">
<table width="100%" cellpadding="0" cellspacing="0" style="padding:32px 16px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 8px 30px rgba(11,45,110,0.12);">
                <tr>
                    <td style="background:linear-gradient(135deg,#0B2D6E 0%,#1a4999 100%);padding:28px 32px;text-align:center;">
                        <h1 style="margin:0;color:#ffffff;font-size:24px;font-weight:700;">SG Holidays</h1>
                        <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:14px;">Dream. Travel. Explore.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 32px;">
                        <h2 style="margin:0 0 16px;font-size:20px;color:#0B2D6E;">Thank You for Contacting Us</h2>
                        <p style="margin:0 0 14px;font-size:15px;line-height:1.7;color:#374151;">
                            Dear {{ $enquiry->name }},
                        </p>
                        <p style="margin:0 0 14px;font-size:15px;line-height:1.7;color:#374151;">
                            Thank you for contacting <strong>SG Holidays</strong>.
                        </p>
                        <p style="margin:0 0 14px;font-size:15px;line-height:1.7;color:#374151;">
                            We have received your enquiry successfully. Our travel consultant will review your request and contact you shortly.
                        </p>
                        <div style="margin:24px 0;padding:18px;background:#f0f4ff;border-radius:12px;border:1px solid #dbeafe;">
                            <p style="margin:0;font-size:14px;color:#1e40af;line-height:1.6;">
                                For urgent assistance, call us or reach us on WhatsApp. We look forward to planning your perfect journey.
                            </p>
                        </div>
                        <p style="margin:0;font-size:15px;line-height:1.7;color:#374151;">
                            Regards,<br>
                            <strong>SG Holidays Team</strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 32px;background:#f9fafb;text-align:center;font-size:12px;color:#9ca3af;">
                        &copy; {{ date('Y') }} SG Holidays. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
