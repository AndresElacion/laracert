<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h1 style="color: #333;">New event coming!</h1>
        <p style="color: #555;">{{ $content }}</p>
        <p style="color: #555;">Thank you for being with us!</p>
        <footer style="margin-top: 20px; font-size: 0.9em; color: #999;">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
