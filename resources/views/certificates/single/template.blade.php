<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
            top: calc(50% - 180px); /* Move up by 20px */
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
            margin-top: 110px;
            height: auto; /* Allow dynamic height based on content */
            display: flex; /* Use flexbox for positioning */
            flex-wrap: wrap; /* Allow wrapping for multiple coordinators */
            justify-content: space-around; /* Evenly distribute coordinators */
            align-items: center; /* Align coordinators vertically */
            gap: 40px; /* Space between coordinators */
        }
        .signature {
            font-size: 35px;
            text-align: center; /* Center-align all text */
            position: absolute;
            width: 550px; /* Match the width of the signature line */
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
            font-family: Arial, Helvetica, sans-serif;
            margin: 0; /* Remove margin */
            line-height: 1; /* Tighten line height */
        }
    </style>
</head>
<body>
    <div class="certificate">
        @if($event->certificateTemplateCategory && $event->certificateTemplateCategory->certificate_template)
            <img class="background" src="{{ public_path('storage/' . $event->certificateTemplateCategory->certificate_template) }}" />
        @endif
        
        <div class="content-wrapper">
            <div class="content">
                <h2 class="name">{{ $user['name'] }}</h2>
                
                @if($remarks)
                    <div class="remarks">
                        <h3><strong>{{ $remarks }}</strong></h3>
                    </div>
                @endif

                <h3><strong>{{ $event->name }}</strong></h3><br>
                <h3>on {{ $certificateDate }}</h3>
            </div>

            <div class="coordinators">
                @foreach($coordinators as $index => $coordinator)
                    <div class="signature coordinator-{{ $index }}">
                        <div class="signature-line"></div>
                        <div class="coordinator-name">{{ $coordinator->name ?? 'Event Coordinator Name' }}</div>
                        <div class="coordinator-title">{{ $coordinator->title ?? 'Event Coordinator Title' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>