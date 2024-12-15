<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>E-CERT - Professional Certification Platform</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Navbar -->
        <header class="fixed w-full bg-white/90 backdrop-blur-sm shadow-sm z-50">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-pink-500">CICT</h1>
                    </div>                   
                    <nav class="flex items-center">
                        <a href="#about" 
                            class="px-2 py-2 rounded-full text-gray-700 hover:text-pink-500 transition-colors">
                            About
                        </a>
                        <a href="#contact" 
                            class="text-nowrap px-2 py-2 rounded-full text-gray-700 hover:text-pink-500 transition-colors">
                            Contact Us
                        </a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                class="px-2 py-2 rounded-full text-gray-700 hover:text-pink-500 transition-colors">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                class="text-nowrap px-2 py-2 rounded-full text-gray-700 hover:text-pink-500 transition-colors">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                    class="text-nowrap px-2 py-2 rounded-full bg-pink-500 text-white hover:bg-pink-600 transition-colors">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative h-screen w-full">
            <!-- Background Image -->
            <img src="./img/Hero1.png" alt="Background Image" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>

            <!-- Content -->
            <div class="absolute inset-0 flex flex-col lg:flex-row items-center justify-center text-center lg:text-left px-4">
                <!-- Left Logo -->
                <div class="mb-6 lg:mb-0 lg:mr-6">
                    <img src="./img/tculogo.png" alt="TCU Logo" class="w-32 lg:w-40 mx-auto lg:mx-0">
                </div>

                <!-- Main Text -->
                <div class="lg:max-w-8xl text-center">
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-4 leading-tight">
                        Taguig City University
                    </h2>
                    <h3 class="text-2xl sm:text-3xl lg:text-5xl text-pink-500">
                        Event Management System
                    </h3>
                </div>

                <!-- Right Logo -->
                <div class="mt-6 lg:mt-0 lg:ml-6">
                    <img src="./img/cictlogo.png" alt="CICT Logo" class="w-32 lg:w-40 mx-auto lg:mx-0">
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2">
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">About</h3>
                        <p class="text-lg text-gray-600 mb-6">
                            Our digital certification platform streamlines the process of creating, distributing, and verifying certificates for all TCU-related activities:
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Secure Digital Certificates</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Easy Sharing & Verification</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Professional Templates</span>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:w-1/2 grid grid-cols-2 gap-4">
                        <img src="/img/event_1.jpg" alt="event_1" class="rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                        <img src="/img/event_2.jpg" alt="event_2" class="rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                        <img src="/img/event_3.jpg" alt="event_3" class="rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                        <img src="/img/event_4.jpg" alt="event_4" class="rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
            </div>
        </section>

        {{-- dev --}}
        <section class="flex justify-center items-center py-12 bg-gradient-to-br from-pink-500 to-purple-600 text-white">
            <div class="container mx-auto px-4"> 
                <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center pb-5">Meet the creator</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="hover:scale-[105%] ease-out border rounded-lg p-4 shadow hover:shadow-md transition duration-300 flex flex-col">
                        <div class="mb-4">
                            <img src="/img/dev/anne.png" alt="Event Image" class="w-full h-80 object-cover rounded-xl border">
                        </div>
                        <div class="items-start mb-2 space-x-2">
                            <h3 class="text-xl font-semibold">Amarille, Joanne H.</h3>
                            <p class="text-black">Fullstack developer</p>
                        </div>
                    </div>

                    <div class="hover:scale-[105%] ease-out border rounded-lg p-4 shadow hover:shadow-md transition duration-300 flex flex-col">
                        <div class="mb-4">
                            <img src="/img/dev/kris.png" alt="Event Image" class="w-full h-80 object-cover rounded-xl border">
                        </div>
                        <div class="items-start mb-2 space-x-2">
                            <h3 class="text-xl font-semibold">Consigo, Kristopper Zimon Carl T.</h3>
                            <p class="text-black">Front-end developer</p>
                        </div>
                    </div>

                    <div class="hover:scale-[105%] ease-out border rounded-lg p-4 shadow hover:shadow-md transition duration-300 flex flex-col">
                        <div class="mb-4">
                            <img src="/img/dev/abby.png" alt="Event Image" class="w-full h-80 object-cover rounded-xl border">
                        </div>
                        <div class="items-start mb-2 space-x-2">
                            <h3 class="text-xl font-semibold">Garucha, Abby Mhare S.</h3>
                            <p class="text-black">Back-end developer</p>
                        </div>
                    </div>

                    <div class="hover:scale-[105%] ease-out border rounded-lg p-4 shadow hover:shadow-md transition duration-300 flex flex-col">
                        <div class="mb-4">
                            <img src="/img/dev/michael.png" alt="Event Image" class="w-full h-80 object-cover rounded-xl border">
                        </div>
                        <div class="items-start mb-2 space-x-2">
                            <h3 class="text-xl font-semibold">Maminta, Michael M.</h3>
                            <p class="text-black">Front-end developer</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>

        <!-- Events Section -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Upcoming Events</h3>
                    <p class="text-gray-600">Join our latest certification events and enhance your professional profile</p>
                </div>

                @if ($upcomingEvents->isEmpty())
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg">No upcoming events at the moment.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($upcomingEvents->take(4) as $event)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all transform hover:scale-105">
                            <div class="p-6">
                                <div class="flex items-center text-pink-500 mb-4">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $event->event_date->format('F d, Y') }} - {{ $event->end_date->format('F d, Y') }}
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 mb-3">{{ $event->name }}</h4>
                                <p class="text-gray-600 mb-6">{{ Str::limit($event->description, 120) }}</p>
                                <a href="{{ route('events.index') }}" 
                                   class="inline-flex items-center px-6 py-2 rounded-full bg-pink-500 text-white hover:bg-pink-600 transition-colors">
                                    Join Now
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h3>
                    <p class="text-gray-600">Find answers to common questions about our e-certification platform</p>
                </div>

                <div class="max-w-3xl mx-auto">
                    <div class="space-y-4">
                        {{-- FAQ1 --}}
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all transform hover:scale-105">
                            <button onclick="toggleAccordion('item1')" class="w-full text-left p-6 focus:outline-none">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">How can I download my e-certificate?</span>
                                    <svg class="w-6 h-6 text-pink-500 transform transition-transform duration-300" id="arrow-item1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>
                            <div id="item1" class="hidden px-6 pb-6">
                                <p class="text-gray-600">Once you are logged into your account, navigate to the "My Certificates" section. From there, you'll see a list of available certificates. Simply click the download icon next to the certificate you wish to download.</p>
                            </div>
                        </div>

                        {{-- FAQ2 --}}
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all transform hover:scale-105">
                            <button onclick="toggleAccordion('item2')" class="w-full text-left p-6 focus:outline-none">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">What format will the e-certificate be in?</span>
                                    <svg class="w-6 h-6 text-pink-500 transform transition-transform duration-300" id="arrow-item1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>
                            <div id="item2" class="hidden px-6 pb-6">
                                <p class="text-gray-600">All e-certificates are generated and provided in PDF format, ensuring compatibility across different devices and platforms.</p>
                            </div>
                        </div>

                        {{-- FAQ3 --}}
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all transform hover:scale-105">
                            <button onclick="toggleAccordion('item3')" class="w-full text-left p-6 focus:outline-none">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Can I customize the design of my e-certificate?</span>
                                    <svg class="w-6 h-6 text-pink-500 transform transition-transform duration-300" id="arrow-item1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>
                            <div id="item3" class="hidden px-6 pb-6">
                                <p class="text-gray-600">The design of your e-certificate is determined by the event organization and is not customizable. The template and background image are set by the event organizers to ensure a consistent look for all participants.</p>
                            </div>
                        </div>

                        {{-- FAQ4 --}}
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all transform hover:scale-105">
                            <button onclick="toggleAccordion('item4')" class="w-full text-left p-6 focus:outline-none">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Why can't I see my certificate after completing the event?</span>
                                    <svg class="w-6 h-6 text-pink-500 transform transition-transform duration-300" id="arrow-item1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>
                            <div id="item4" class="hidden px-6 pb-6">
                                <p class="text-gray-600">Certificates are usually available within 24 hours after requesting the certificate. If you still can't see it, please ensure your email is verified and check your event completion status. For further assistance, contact our support team.</p>
                            </div>
                        </div>

                        <!-- Additional FAQ items follow the same pattern -->
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-pink-500 to-purple-600 text-white">
            <div class="container mx-auto px-4 text-center">
                <h3 class="text-3xl font-bold mb-6">Join TCU's Digital Certificate Platform</h3>
                <p class="text-xl mb-8 opacity-90">Access and manage your university certificates with ease</p>
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center px-8 py-3 rounded-full bg-white text-pink-500 hover:shadow-xl transition-all transform hover:scale-105">
                    Create Your Account
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Contact Us</h3>
                    <p class="text-gray-600">Have questions or need assistance? Reach out to us!</p>
                </div>

                @if (session('success'))
                    <div id="success-message" class="max-w-4x mb-4 text-green-600 bg-green-100 p-4 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif


                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                                <input type="text" id="name" name="name" required 
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:outline-none" 
                                    placeholder="Your full name">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" id="email" name="email" required 
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:outline-none" 
                                    placeholder="Your email address">
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" required 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:outline-none" 
                                placeholder="Subject of your message">
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                            <textarea id="message" name="message" rows="6" required 
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:outline-none" 
                                    placeholder="Write your message here..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" 
                                    class="px-8 py-3 rounded-full bg-pink-500 text-white hover:bg-pink-600 transition-all transform hover:scale-105">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-12">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h4 class="text-2xl font-bold text-white mb-4">E-CERT</h4>
                    <p class="mb-6">Transform your achievements into digital excellence</p>
                    <p>&copy; 2024 E-CERT System. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            function toggleAccordion(itemId) {
                const content = document.getElementById(itemId);
                const arrow = document.getElementById('arrow-' + itemId);
                
                content.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            }

            document.addEventListener('DOMContentLoaded', function () {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    setTimeout(() => {
                        successMessage.style.transition = 'opacity 0.5s';
                        successMessage.style.opacity = '0';
                        setTimeout(() => successMessage.remove(), 500); // Remove element after fade-out
                    }, 3000); // Adjust time (3000ms = 3 seconds)
                }
            });
        </script>
    </body>
</html>