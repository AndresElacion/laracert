<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .certificate {
            width: 100%;
            height: 100%;
            position: relative;
            color: #333;
            text-align: center;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .content-wrapper {
            position: absolute;
            top: 50%;
            left: calc(50% - 310px);
            transform: translate(-50%, -50%);
            color: black;
            text-align: center;
        }
        .content {
            font-size: 50px;
            margin-top: 750px;
        }
        .content .name {
            font-size: 120px; /* Increased from 90px */
            margin-right: 50px;
            font-weight: bold; /* Added to ensure name is bold */
            line-height: 1.3; /* Added to prevent line overlap */
            margin-bottom: 80px; /* Added space below the name */
        }
        .content h3 {
            margin: 20px 0; /* Reduced margin top and bottom */
            line-height: 1.2; /* Reduced line height */
            padding: 0; /* Remove any padding */
        }
        .coordinators {
            position: relative;
            margin-top: 100px;
            height: 400px; /* Adjusted height */
        }
        .signature {
            font-size: 35px;
            text-align: center;
            position: absolute;
            width: 400px; /* Fixed width for signature blocks */
        }
        /* Individual coordinator positioning */
        .coordinator-0 { /* Top left */
            left: 0;
            top: 0;
        }
        .coordinator-1 { /* Top right */
            right: 0;
            top: 0;
        }
        .coordinator-2 { /* Middle center */
            left: 50%;
            transform: translateX(-50%);
            top: 120px; /* Adjust this value to control vertical spacing */
        }
        .coordinator-3 { /* Bottom left */
            left: 0;
            top: 240px; /* Adjust this value to control vertical spacing */
        }
        .coordinator-4 { /* Bottom right */
            right: 0;
            top: 240px; /* Adjust this value to control vertical spacing */
        }
        .signature-line {
            width: 400px;
            border-bottom: 2px solid #000;
            margin: 10px auto;
        }

        .coordinator-name {
            font-size: 50px
        }
    </style>
</head>
<body>
    <div class="certificate">
        <img class="background" src="{{ public_path('storage/' . $event->certificateTemplateCategory->certificate_template) }}" />
        
        <div class="content-wrapper">
            <div class="content">
                <h2 class="name"><strong>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</strong></h2>
                <h3>has successfully participated in</h3>
                <h3><strong>{{ $event->name }}</strong></h3>
                <h3>on {{ $event->event_date->format('F d, Y') }}</h3>
            </div>

            <div class="coordinators">
                @foreach($certificate->eventRegistration->event->coordinators as $index => $coordinator)
                    <div class="signature coordinator-{{ $index }}">
                        <div class="signature-line"></div>
                        <p class="coordinator-name">{{ $coordinator->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>