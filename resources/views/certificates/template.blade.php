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
            top: calc(50% - 370px); /* Move up by 20px */
            left: calc(50% - 70px);
            transform: translate(-50%, -50%);
            color: black;
            text-align: center;
            width: 2500px;
        }
        .content {
            font-size: 50px;
            margin-top: 750px;
        }
        .content .name {
            font-size: 150px; /* Increased from 90px */
            margin-right: 50px;
            font-weight: bold; /* Added to ensure name is bold */
            line-height: 1.3; /* Added to prevent line overlap */
            margin-bottom: 10px; /* Added space below the name */
            font-style: italic;
        }
        .content h3 {
            margin: 0; /* Reduced margin top and bottom */
            line-height: 1.2; /* Reduced line height */
            padding: 0; /* Remove any padding */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: left;
        }
        .coordinators {
            position: relative;
            margin-top: 110px;
            height: auto; /* Allow dynamic height based on content */
            display: flex; /* Use flexbox for positioning */
            flex-wrap: nowrap; /* Allow wrapping for multiple coordinators */
            justify-content: center; /* Evenly distribute coordinators */
            align-items: center; /* Align coordinators vertically */
            gap: 20px;
        }
        .signature {
            font-size: 35px;
            text-align: center; /* Center-align all text */
            position: absolute;
            width: 900px; /* Match the width of the signature line */
            margin: 20px auto; /* Add spacing between signatures */
            display: flex;
            flex-direction: column; /* Stack elements vertically */
            align-items: center; /* Center elements horizontally */
            justify-content: center; /* Center elements vertically */
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
            top: 180px; /* Increased spacing */
        }

        .coordinator-3 { /* Bottom left */
            left: 0;
            top: 360px; /* Increased spacing */
        }

        .coordinator-4 { /* Bottom right */
            right: 0;
            top: 360px; /* Increased spacing */
        }

        .signature-line {
            width: 550px; /* Reduced width for better fit */
            border-bottom: 2px solid #000;
            margin: 5px auto; /* Minimized margin for spacing */
        }
        .coordinator-name {
            font-size: 50px; /* Reduced font size */
            font-family: Arial, Helvetica, sans-serif;
            margin: 5px 0; /* Minimize spacing above and below */
            line-height: 1; /* Tighten line height */
        }
        .coordinator-title {
            font-size: 40px; /* Reduced font size */
            font-style: italic;
            margin: 0; /* Remove margin */
            line-height: 1; /* Tighten line height */
        }
    </style>
</head>
<body>
    <div class="certificate">
        <img class="background" src="{{ public_path('storage/' . $event->certificateTemplateCategory->certificate_template) }}" />
        
        <div class="content-wrapper">
            <div class="content">
                <h2 class="name"><strong>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</strong></h2>
                <h3>{{ $event->certificateTemplateCategory->description }} <strong>{{ $event->name }}</strong> on {{ $event->event_date->format('F d, Y') }}</h3>
            </div>

            <div class="coordinators">
                @foreach($certificate->eventRegistration->event->coordinators as $index => $coordinator)
                    <div class="signature coordinator-{{ $index }}">
                        <div class="signature-line"></div>
                        <p class="coordinator-name">{{ $coordinator->name }}</p>
                        <p class="coordinator-title">{{ $coordinator->title }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>