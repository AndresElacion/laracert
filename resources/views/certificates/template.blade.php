<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
        }
        .certificate {
            border: 20px solid #0066cc;
            padding: 25px;
            height: 600px;
            position: relative;
        }
        .title {
            font-size: 50px;
            font-weight: bold;
            color: #0066cc;
            margin-bottom: 50px;
        }
        .content {
            font-size: 24px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="title">Certificate of Completion</div>
        <div class="content">
            This is to certify that<br>
            <strong>{{ $user->name }}</strong><br>
            has successfully participated in<br>
            <strong>{{ $event->name }}</strong><br>
            on {{ $event->event_date->format('F d, Y') }}
        </div>
    </div>
</body>
</html>