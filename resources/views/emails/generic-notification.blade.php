<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $notification->title }}</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f7fafc; padding:24px; color:#1f2937;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:12px; padding:24px;">
        <h1 style="margin:0 0 12px; font-size:20px; color:#111827;">{{ $notification->title }}</h1>
        <p style="margin:0 0 16px; line-height:1.6;">{{ $notification->message }}</p>
        @if($notification->data && isset($notification->data['action_url']))
            <p style="margin:24px 0;">
                <a href="{{ $notification->data['action_url'] }}" style="display:inline-block; background:#2563eb; color:#ffffff; text-decoration:none; padding:10px 16px; border-radius:8px;">Lihat Detail</a>
            </p>
        @endif
        <p style="font-size:12px; color:#6b7280; margin-top:24px;">Email ini dikirim otomatis oleh sistem 7PLAY.</p>
    </div>
</body>
</html>


