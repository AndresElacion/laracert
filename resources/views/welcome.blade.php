<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-50">
            <div class="flex flex-col">
                <div class="">
                    <header class="flex items-center container mx-auto py-4">
                        <h1>E-CERT</h1>
                        @if (Route::has('login'))
                            <nav class="flex flex-1 justify-end">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <!-- Hero -->
                    <section id="hero" class="relative h-[43rem] overflow-hidden">
                        <img src="./img/Hero.png" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover">
                    </section>

                    <!-- About -->
                    <section id="about" class="py-12 bg-gray-100">
                        <div class="container mx-auto">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-md">
                                    In the digital age, e-certification has emerged as a transformative tool for validating skills and knowledge across various fields. E-certification refers to the electronic issuance and management of certificates, typically through online platforms. This modern approach offers a range of benefits over traditional paper-based certifications, including increased accessibility, enhanced security, and greater efficiency.
                                    </p>
                                    <div class="mt-5">
                                        <button class="flex items-center justify-between bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 px-4 rounded-full transition duration-300 transform hover:scale-105">
                                            <a href="{{ route('register') }}" class="mr-2 font-bold">
                                                Get Started
                                            </a>
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                                </svg>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <img src="./img/template_1.jpg" alt="" class="hover:scale-105 transition-transform duration-300 rounded-lg shadow-lg">
                                    <img src="./img/template_2.png" alt="" class="hover:scale-105 transition-transform duration-300 rounded-lg shadow-lg">
                                    <img src="./img/template_3.jpg" alt="" class="hover:scale-105 transition-transform duration-300 rounded-lg shadow-lg"> 
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Events -->
                    <div class="container mx-auto px-4">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-8">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-2xl font-bold">Upcoming Events</h2>
                                </div>

                                @if ($upcomingEvents->isEmpty())
                                    <div class="text-center py-8">
                                        <p class="text-gray-500">No upcoming events at the moment.</p>
                                    </div>
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                                        @foreach($upcomingEvents->take(4) as $event)
                                        <div class="bg-white hover:bg-gray-100 rounded-lg shadow-md overflow-hidden transition-all duration-300 transform hover:scale-[102%]">
                                            <div class="md:flex">
                                                <div class="md:flex-shrink-0">
                                                </div>
                                                <div class="p-6">
                                                    <div class="flex items-center text-sm text-indigo-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ $event->event_date->format('F d, Y - h:i A') }}
                                                    </div>
                                                    <p class="block mt-1 text-lg leading-tight font-medium text-black">
                                                        {{ $event->name }}
                                                    </p>
                                                    <p class="mt-2 text-gray-500">
                                                        {{ Str::limit($event->description, 120) }}
                                                    </p>
                                                    <div class="mt-4">
                                                        <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                        Join Now
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    

                    <!-- FAQ Section -->
                    <section id="faq" class="py-16 bg-white">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl mx-auto text-center">
                                <h1 class="text-4xl font-bold text-gray-800 mb-6">Frequently Asked Questions</h1>
                                <p class="text-gray-600 mb-12">Here are the most common questions we receive about e-certificate downloads. If you have any further questions, feel free to contact us!</p>
                            </div>

                            <div class="max-w-7xl mx-auto grid grid-cols-2 gap-4">
                                <div class="space-y-4">
                                    <!-- Question 1 -->
                                    <div class="bg-white shadow-lg rounded-lg">
                                        <button onclick="toggleAccordion('item1')" class="border-b w-full text-left p-6 flex justify-between items-center">
                                            <span class="text-xl font-semibold text-gray-700">1. How can I download my e-certificate?</span>
                                            <svg class="w-6 h-6 transform transition-transform duration-300" id="arrow-item1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <div id="item1" class="accordion-content p-6 hidden">
                                            <p class="text-gray-600">Once you are logged into your account, navigate to the "My Certificates" section. From there, you'll see a list of available certificates. Simply click the download icon next to the certificate you wish to download.</p>
                                        </div>
                                    </div>

                                    <!-- Question 2 -->
                                    <div class="bg-white shadow-lg rounded-lg">
                                        <button onclick="toggleAccordion('item2')" class="border-b w-full text-left p-6 flex justify-between items-center">
                                            <span class="text-xl font-semibold text-gray-700">2. What format will the e-certificate be in?</span>
                                            <svg class="w-6 h-6 transform transition-transform duration-300" id="arrow-item2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <div id="item2" class="accordion-content p-6 hidden">
                                            <p class="text-gray-600">All e-certificates are generated and provided in PDF format, ensuring compatibility across different devices and platforms.</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="space-y-4">
                                    <!-- Question 3 -->
                                    <div class="bg-white shadow-lg rounded-lg">
                                        <button onclick="toggleAccordion('item3')" class="border-b w-full text-left p-6 flex justify-between items-center">
                                            <span class="text-xl font-semibold text-gray-700">3. Can I customize the design of my e-certificate?</span>
                                            <svg class="w-6 h-6 transform transition-transform duration-300" id="arrow-item3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <div id="item3" class="accordion-content p-6 hidden">
                                            <p class="text-gray-600">Yes! You can customize your certificate design by selecting from a variety of templates provided in your account settings. You can also upload a background image to personalize it further.</p>
                                        </div>
                                    </div>

                                    <!-- Question 4 -->
                                    <div class="bg-white shadow-lg rounded-lg">
                                        <button onclick="toggleAccordion('item4')" class="border-b w-full text-left p-6 flex justify-between items-center">
                                            <span class="text-xl font-semibold text-gray-700">4. Why can't I see my certificate after completing the event?</span>
                                            <svg class="w-6 h-6 transform transition-transform duration-300" id="arrow-item4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <div id="item4" class="accordion-content p-6 hidden">
                                            <p class="text-gray-600">Certificates are usually available within 24 hours after completing the event. If you still can't see it, please ensure your email is verified and check your event completion status. For further assistance, contact our support team.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Call to Action -->
                    <section id="cta" class="py-12 bg-gray-100">
                        <div class="container mx-auto text-center">
                            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Ready to get started?</h2>
                            <p class="text-gray-600 mb-4">Join thousands of users who have already discovered the ease of e-certification!</p>
                            <button class="bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 px-4 rounded-full transition duration-300 transform hover:scale-105">
                                <a href="{{ route('register') }}">Create Your Account</a>
                            </button>
                        </div>
                    </section>

                    <footer class="bg-gray-800 text-white p-4 mt-6">
                        <div class="container mx-auto text-center">
                            <p>&copy; 2024 E-Cert System. All rights reserved.</p>
                        </div>
                    </footer>

                    <script>
                        function toggleAccordion(itemId) {
                            const content = document.getElementById(itemId);
                            const arrow = document.getElementById('arrow-' + itemId);

                            content.classList.toggle('hidden');
                            arrow.classList.toggle('rotate-90');
                        }
                    </script>
                </div>
            </div>
        </div>
    </body>
</html>
