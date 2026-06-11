<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Enquiry - SG Holidays</title>
</head>
<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial,Helvetica,sans-serif;color:#1a1a2e;">
@php
    $packageTitle = $enquiry->package?->title ?? 'General Enquiry';
    $destination = $enquiry->destination
        ?? $enquiry->package?->destination?->name
        ?? 'Not specified';
    $travelDate = $enquiry->travel_date
        ? \Carbon\Carbon::parse($enquiry->travel_date)->format('d M Y')
        : 'Not specified';
    $persons = $enquiry->number_of_persons ?? 'Not specified';
    $submittedAt = $enquiry->created_at?->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A');
@endphp
<table width="100%" cellpadding="0" cellspacing="0" style="padding:32px 16px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 8px 30px rgba(11,45,110,0.12);">
                <tr>
                    <td style="background:linear-gradient(135deg,#0B2D6E 0%,#1a4999 100%);padding:28px 32px;">
                        <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:700;">New Enquiry Received</h1>
                        <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:14px;">SG Holidays Admin Notification</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:32px;">
                        <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#4b5563;">
                            A new travel enquiry has been submitted on the website. Details are below:
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                            @foreach([
                                'Customer Name' => $enquiry->name,
                                'Customer Email' => $enquiry->email ?: 'Not provided',
                                'Customer Phone' => $enquiry->phone,
                                'Package' => $packageTitle,
                                'Destination' => $destination,
                                'Travel Date' => $travelDate,
                                'Number of Persons' => $persons,
                                'Enquiry Timestamp' => $submittedAt,
                            ] as $label => $value)
                            <tr>
                                <td style="padding:14px 16px;background:#f9fafb;width:38%;font-size:13px;font-weight:700;color:#0B2D6E;border-bottom:1px solid #e5e7eb;">{{ $label }}</td>
                                <td style="padding:14px 16px;font-size:14px;color:#374151;border-bottom:1px solid #e5e7eb;">{{ $value }}</td>
                            </tr>
                            @endforeach
                        </table>
                        @if($enquiry->message)
                        <div style="margin-top:24px;padding:18px;background:#fffbeb;border-left:4px solid #F59E0B;border-radius:8px;">
                            <p style="margin:0 0 8px;font-size:12px;font-weight:700;color:#92400e;text-transform:uppercase;letter-spacing:0.05em;">Message</p>
                            <p style="margin:0;font-size:14px;line-height:1.7;color:#374151;white-space:pre-wrap;">{{ $enquiry->message }}</p>
                        </div>
                        @endif
                        <p style="margin:28px 0 0;font-size:13px;color:#6b7280;">
                            Please follow up with the customer at the earliest convenience.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 32px;background:#f9fafb;text-align:center;font-size:12px;color:#9ca3af;">
                        &copy; {{ date('Y') }} SG Holidays. This is an automated notification.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
