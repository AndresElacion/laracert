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
            left: 50%;
            transform: translate(-50%, -50%);
            color: #333;
            text-align: center;
        }
        .content {
            font-size: 50px; /* Smaller font size for content */
            line-height: 1.2;
        }
        .content h2 {
        }
        .content h3 {
            margin-top: 5px; /* Reduced margin */
        }
        .signature {
            margin-top: 30px; /* Reduced space for signature */
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <!-- Background image positioning controlled by .background class -->
        <img class="background" src="{{ public_path('storage/' . $event->certificateTemplateCategory->certificate_template) }}" />
        
        <!-- Main content wrapper - center everything inside -->
        <div class="content-wrapper">
            <div class="content">
                <h2><strong>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</strong></h2>
                <h3>has successfully participated in</h3>
                <h3><strong>{{ $event->name }}</strong></h3>
                <h3>on {{ $event->event_date->format('F d, Y') }}</h3>
                
                @foreach($certificate->eventRegistration->event->coordinators as $coordinator)
                    <p>{{ $coordinator->name}}</p>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
