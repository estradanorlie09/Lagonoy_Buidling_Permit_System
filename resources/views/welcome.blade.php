@include('partials._header')

@include('components.landing_page_navbar')
<div class="relative w-full h-screen overflow-hidden">
    <!-- Slides Container -->
    <div id="slider" class="flex transition-transform duration-700 ease-in-out w-full h-full">
        <img src="https://scontent.fmnl44-1.fna.fbcdn.net/v/t39.30808-6/514252594_1105810811472063_6102943932776777623_n.jpg?stp=cp6_dst-jpg_s960x960_tt6&_nc_cat=108&ccb=1-7&_nc_sid=cc71e4&_nc_ohc=pLOngNuPCSgQ7kNvwEfVFM1&_nc_oc=AdkEqi1iPcBIv5dMpsDWV1d7v_0swe6HTf7cjWenOfHx8UGomEOQurter8iqtCYMeTE&_nc_zt=23&_nc_ht=scontent.fmnl44-1.fna&_nc_gid=3qu2tSNYaRWraQ24fLEAfA&oh=00_AfW-2U2PEYAbQvyRWMV6ngNvy6cdzsw5CgoA37s3Ih6wBQ&oe=68BB8374"
            class="w-full h-screen object-cover flex-shrink-0" />
        <img src="https://elgu-news-cdn.e.gov.ph/san-jose-camarines-sur/uploads/SJP%20ACRERA%20DE%20COLOR.jpg"
            class="w-full h-screen object-cover flex-shrink-0" />
        <img src="https://scontent.fmnl44-1.fna.fbcdn.net/v/t39.30808-6/483829986_632753886175491_8411716321649618583_n.jpg?stp=dst-jpg_s960x960_tt6&_nc_cat=101&ccb=1-7&_nc_sid=cc71e4&_nc_ohc=uIMeUvu1C80Q7kNvwFXNJdK&_nc_oc=AdnftTvRJZ_SE9rDDon7pLUYQZR4suTdBKmQ3iLqWnkKOs9htpztupJcbEebWHt8aps&_nc_zt=23&_nc_ht=scontent.fmnl44-1.fna&_nc_gid=LKqc-Nk2LVfExDlZwAYvhw&oh=00_AfU-1U7LMTKns544bZbbNHwmzxfp8_NqV9o-4xbwRai-2A&oe=68BB972C"
            class="w-full h-screen object-cover flex-shrink-0" />
    </div>

    <!-- Overlay with Centered Text -->
    <div class="absolute inset-0 bg-black/85 flex items-center justify-center px-6">
        <div class="max-w-4xl text-center text-white">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-6 leading-tight drop-shadow-lg">
                Welcome to <span class="text-white">Lagonoy</span><br />
                <span
                    class="inline-flex items-center justify-center gap-3 mt-2 text-3xl sm:text-4xl font-semibold text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                    </svg>
                    Building Epermit System
                </span>
            </h1>
            <p class="text-sm sm:text-lg md:text-xl font-medium max-w-3xl mx-auto drop-shadow-md leading-relaxed mb-8">
                Simplify your building permit application with our easy-to-use online platform. Fast, reliable, and
                hassle-free — get your permits approved quickly so you can start building with confidence.
            </p>

            <!-- Buttons -->
            <div class="flex justify-center gap-6">
                <a href="#guide"
                    class="px-8 py-3 border border-red-600 hover:bg-red-600 hover:text-white rounded text-red-400 font-semibold text-lg transition">
                    Guide
                </a>
                <a href="{{ route('signup') }}"
                    class="px-8 py-3 bg-red-600 hover:bg-red-700 rounded text-white font-semibold text-lg transition">
                    Get Started
                </a>

            </div>
        </div>
    </div>
</div>
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">About Us</h1>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Who We Are 👷‍♂️</h2>
        <p class="text-gray-600 leading-relaxed">
            We are a team of building permit consultants, engineers, and project coordinators with
            <span class="font-semibold">[X]+ years</span> of experience navigating the complex world of construction
            permits.
            Whether you're building a new home, renovating a commercial space, or planning an addition, we help
            streamline the permitting process so your project can move forward—on time and stress-free.
        </p>
    </div>

    <div>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Our Mission 🎯</h2>
        <p class="text-gray-600 leading-relaxed">
            Our mission is to remove the red tape from your construction journey by offering reliable, efficient, and
            expert
            permit services tailored to your needs.
        </p>
    </div>
    <!-- Contact Us -->
    <section class="mb-16 w-full mt-10">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Contact Us</h2>

        <form class="grid gap-6 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <label class="block text-gray-700 font-medium mb-1" for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your full name"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="sm:col-span-1">
                <label class="block text-gray-700 font-medium mb-1" for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="sm:col-span-2">
                <label class="block text-gray-700 font-medium mb-1" for="message">Message</label>
                <textarea id="message" name="message" rows="5" placeholder="How can we help you?"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="sm:col-span-2 text-center">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    Send Message
                </button>
            </div>
        </form>
    </section>

    <!-- FAQ -->
    <section>
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Frequently Asked Questions</h2>

        <div class="space-y-8">

            <!-- FAQ Item 1 -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Do I need a permit for a home renovation?</h3>
                <p class="text-gray-600 mt-2">
                    Most structural renovations, electrical, plumbing, and additions require a permit. We can check
                    local codes for you and handle the application.
                </p>
            </div>

            <!-- FAQ Item 2 -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700">How long does the permit process take?</h3>
                <p class="text-gray-600 mt-2">
                    It varies by city and project type. On average, residential permits take 2–4 weeks. We aim to
                    minimize delays by preparing complete, compliant submissions.
                </p>
            </div>

            <!-- FAQ Item 3 -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Can you help with rejected or delayed applications?</h3>
                <p class="text-gray-600 mt-2">
                    Yes! We specialize in troubleshooting rejected applications and resubmitting with corrections to
                    ensure approval.
                </p>
            </div>

        </div>
    </section>
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
