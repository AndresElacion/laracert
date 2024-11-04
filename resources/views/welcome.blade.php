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
                    <section id="hero" class="relative bg-cover bg-center h-96" style="background-image: url('./img/hero.webp');">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-start">
                            <div class="container mx-auto">
                                <h1 class="text-white text-5xl font-bold mb-4 uppercase">e-certification</h1>
                                <p class="text-white text-5xl font-bold mb-4 uppercase">maker</p>
                            </div>
                        </div>
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
                                            <a href="./register.php" class="mr-2 font-bold">
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
                                <a href="./register.php">Create Your Account</a>
                            </button>
                        </div>
                    </section>

                    <!-- Contact -->
                    <section id="contact" class="bg-white py-16">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl mx-auto text-center">
                                <h1 class="text-4xl font-bold text-gray-800 mb-6">Get in Touch with Us</h1>
                                <p class="text-gray-600 mb-12">We'd love to hear from you! Whether you have a question about the certificates, features, pricing, or anything else, our team is ready to assist you.</p>
                            </div>

                            <div class="flex justify-center items-center">
                                <!-- Contact Form -->
                                <div class="bg-white  border rounded-lg shadow-lg p-8 md:w-1/2">
                                    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Send Us a Message</h2>
                                    <form action="#" method="POST">
                                        <div class="mb-4">
                                            <label for="name" class="block text-sm text-gray-600">Full Name</label>
                                            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="block text-sm text-gray-600">Email Address</label>
                                            <input type="email" id="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div class="mb-4">
                                            <label for="message" class="block text-sm text-gray-600">Message</label>
                                            <textarea id="message" name="message" rows="5" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>
                                        <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Send Message</button>
                                    </form>
                                </div>
                            </div>
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

                            if (content.classList.contains('hidden')) {
                                content.classList.remove('hidden');
                                arrow.classList.add('rotate-90');
                            } else {
                                const allContents = document.querySelectorAll('.accordion-content');
                                const allArrows = document.querySelectorAll('svg');
                                allContents.forEach((c) => c.classList.remove('active'));
                                allArrows.forEach((a) => a.classList.remove('transform', 'rotate-90'));

                                content.classList.add('hidden');
                                arrow.classList.remove('rotate-90');
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </body>
</html>
