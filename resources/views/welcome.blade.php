@include('partials._header')
<div class="relative w-full">

    @include('components.landing_page_navbar')
    {{-- Navigation --}}
   

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-blue-800 to-red-700 text-white text-center py-20 px-4">
        <h2 class="text-4xl font-bold mb-4 drop-shadow">
            Streamlined Building Permit Applications
        </h2>
        <p class="text-lg mb-8">
            Fast, Transparent, and Efficient Service for All Filipinos
        </p>
        <a href="#" class="inline-block bg-red-600 hover:bg-red-700 px-8 py-3 rounded font-semibold">
            Apply for Permit Now
        </a>
    </section>

    {{-- Notice --}}
    <section class="max-w-7xl mx-auto px-6 py-10">
        <div class="bg-blue-100 border-l-4 border-blue-700 text-blue-800 p-4 rounded">
            <strong>Notice:</strong> Online applications are now available! Submit your building permit application from
            home.
        </div>
    </section>

    {{-- Services --}}
    <section class="max-w-7xl mx-auto px-6 py-10">
        <h2 class="text-center text-2xl font-bold text-blue-800 mb-10">
            Our Services
        </h2>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $services = [
                    ['🏗️', 'New Construction', 'Apply for permits for new building construction projects'],
                    ['🔧', 'Renovation / Repair', 'Get permits for renovation and repair works'],
                    ['📋', 'Application Status', 'Track your application in real-time'],
                    ['📄', 'Document Upload', 'Submit required documents securely'],
                    ['💳', 'Online Payment', 'Pay permit fees conveniently'],
                    ['📞', 'Help Desk', 'Get assistance from our support team'],
                ];
            @endphp

            @foreach ($services as $service)
                <div
                    class="border-2 border-gray-200 rounded-lg p-8 text-center hover:border-blue-800 hover:shadow-lg hover:-translate-y-1 transition">
                    <div
                        class="w-20 h-20 mx-auto mb-4 rounded-full bg-blue-800 text-white flex items-center justify-center text-3xl">
                        {{ $service[0] }}
                    </div>
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">
                        {{ $service[1] }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ $service[2] }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Requirements --}}
    <section class="bg-gray-100 py-14">
        <div class="max-w-5xl mx-auto px-6 bg-white rounded-lg shadow p-8">
            <h3 class="text-xl font-bold text-blue-800 border-b-4 border-red-600 pb-2 mb-6">
                Documentary Requirements for Building Permit
            </h3>

            <ul class="space-y-3">
                @foreach (['Accomplished Application Form (3 copies)', 'Certified True Copy of Transfer Certificate of Title (TCT)', 'Tax Declaration', 'Architectural Plans (5 sets)', 'Structural Plans (5 sets)', 'Electrical Plans (5 sets)', 'Plumbing / Sanitary Plans (5 sets)', 'Bill of Materials and Cost Estimates', 'Barangay Clearance', 'Locational Clearance', 'Fire Safety Inspection Certificate (if applicable)'] as $req)
                    <li class="flex gap-3 border-b pb-2">
                        <span class="text-red-600 font-bold">✓</span>
                        <span>{{ $req }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="text-center mt-10 space-x-3">
                <a href="#" class="bg-blue-800 hover:bg-blue-900 text-white px-6 py-3 rounded font-semibold">
                    Download Checklist
                </a>
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded font-semibold">
                    Start Application
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-6 py-12 grid gap-8 md:grid-cols-4">
            <div>
                <h4 class="text-yellow-400 font-semibold mb-3">Quick Links</h4>
                <a class="block hover:text-white" href="#">Apply</a>
                <a class="block hover:text-white" href="#">Track</a>
                <a class="block hover:text-white" href="#">Requirements</a>
                <a class="block hover:text-white" href="#">FAQs</a>
            </div>

            <div>
                <h4 class="text-yellow-400 font-semibold mb-3">Resources</h4>
                <a class="block hover:text-white" href="#">National Building Code</a>
                <a class="block hover:text-white" href="#">Zoning Ordinances</a>
                <a class="block hover:text-white" href="#">Forms</a>
            </div>

            <div>
                <h4 class="text-yellow-400 font-semibold mb-3">Contact</h4>
                <p>
                    Office of the Building Official<br>
                    Phone: (02) 1234-5678<br>
                    Email: buildingpermit@gov.ph
                </p>
            </div>

            <div>
                <h4 class="text-yellow-400 font-semibold mb-3">Office Hours</h4>
                <p>Mon–Fri: 8:00 AM – 5:00 PM<br>Sat–Sun: Closed</p>
            </div>
        </div>

        <div class="border-t border-gray-700 text-center py-4 text-sm text-gray-400">
            © 2026 Republic of the Philippines – Building Permit Portal
        </div>
    </footer>
</div>

<script>
    const slider = document.getElementById('slider');
    const slides = slider.children;
    const totalSlides = slides.length;

    let currentIndex = 0;

    function showSlide(index) {
        slider.style.transform = `translateX(-${index * 100}%)`;
    }

    // Auto slide every 3 seconds
    setInterval(() => {
        currentIndex = (currentIndex + 1) % totalSlides;
        showSlide(currentIndex);
    }, 10000);
</script>
@include('partials._footer')
