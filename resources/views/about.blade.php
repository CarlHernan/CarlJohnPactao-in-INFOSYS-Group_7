<x-layout>
    <div class="min-h-screen w-screen overflow-y-auto flex flex-col">
        <!-- about pingganph -->
        <section class="min-h-[120vh] relative flex flex-col bg-stone-300 bg-gradient-to-b from-white/50 to-black/50 bg-blend-soft-light items-center justify-between py-20 text-center gap-4 p-0 md:px-6 md:p-0">
            <h1 class="text-emerald-900 font-bold text-4xl font-merriweather md:text-3xl lg:text-6xl max-w-6xl mt-16 mb-0">About PingganPH</h1>
            <!-- aboutpic -->
            <div class="w-full max-w-4xl mx-auto flex flex-row gap-12 justify-center">
                <img src="/images/adobo.jpg" alt="About PingganPH Image 1" class="max-w-lg h-auto flex-shrink-0 rounded-[30px]" />
                <img src="/images/gata.jpg" alt="About PingganPH Image 2" class="max-w-lg h-auto flex-shrink-0 rounded-[30px]" />
                <img src="/images/karekare.jpg" alt="About PingganPH Image 3" class="max-w-lg h-auto flex-shrink-0 rounded-[30px]" />
            </div>
            <p class="font-poppins text-gray-700 text-lg max-w-4xl pb-6 mb-32">Your trusted partner in choosing delicious meals using the tip of your fingers.</p>
        </section>

        <!-- main content section  -->
        <section class="bg-stone-300 py-20 px-6 lg:px-20 flex flex-col w-full mb-24">
            <div class="w-full space-y-24 max-w-6xl mx-auto">
                <!-- intro -->
                <section class="text-center">
                    <h2 class="font-merriweather text-6xl lg:text-6xl font-bold text-gray-900 leading-tight mb-8">Who We Are</h2>
                    <p class="font-poppins text-gray-700 text-lg max-w-4xl mx-auto mb-16">PingganPH brings quality homemade Filipino meals straight to your hands. What started as a humble Karinderya in Kabacan is now online—serving you your favorite ulam, anytime, anywhere.</p>

                <!-- mission statement -->
                    <h2 class="font-merriweather text-6xl lg:text-6xl font-bold text-gray-900 leading-tight mb-8">Mission Statement</h3>
                    <p class="font-poppins text-gray-700 text-lg max-w-4xl mx-auto mb-16">Our mission is to make homestyle meals accessible to everyone, combining tradition with the convenience of modern technology.</p>
                </section>

                <!-- our story  -->
                <section class="text-center">
                    <h2 class="font-merriweather text-6xl lg:text-6xl font-bold text-gray-900 leading-tight mb-8">Our Story</h3>
                    <div class="space-y-6 text-lg font-merriweather text-gray-800 max-w-4xl mx-auto mb-8">
                        <p>PingganPH was born from a simple idea: to venture and order quality food accessible to everyone, anytime. It is a small local service yet it can connect hundreds of food lovers.</p>
                        <p>We've revolutionized the way people experience in ordering food by focusing on speed, quality, and an extensive selection of cuisines from the local eatery.</p>
                        <p>Today, we continue to innovate with real-time tracking, smart recommendations, and seamless ordering experiences that make every meal special.</p>
                        <p>Human connection is important—people love knowing the heart behind the food.</p>
                    </div>
                </section>

                <section class="space-y-8 w-full mb-8">
                    <div class="flex flex-row gap-10 justify-center items-stretch max-w-6xl mx-auto">
                        <!-- what makes us different -->
                        <section class="flex-1 bg-amber-500 p-8 rounded-lg shadow-md max-w-md min-h-[280px] flex flex-col">
                            <div class="flex-1 flex flex-col">
                                <h3 class="font-merriweather text-2xl font-bold text-gray-900 mb-6 text-center">What Makes Us Different</h3>
                                <ul class="space-y-3 text-lg font-merriweather text-gray-800 list-disc list-inside text-left flex-1">
                                    <li>Homestyle, lutong-bahay taste</li>
                                    <li>Fresh and affordable meals</li>
                                    <li>Convenient online ordering system</li>
                                    <li>Fast local delivery</li>
                                </ul>
                                <p class="font-poppins text-gray-700 text-lg italic mt-6 text-left">Unlike big fast-food chains, we cook with care and tradition—just like how mom makes it at home.</p>
                            </div>
                        </section>

                        <!-- how it works -->
                        <section class="flex-1 bg-amber-500 p-8 rounded-lg shadow-md max-w-md min-h-[280px] flex flex-col">
                            <div class="flex-1 flex flex-col">
                                <h3 class="font-merriweather text-2xl font-bold text-gray-900 mb-6 text-center">How It Works</h3>
                                <ul class="space-y-3 text-lg font-merriweather text-gray-800 list-disc list-inside text-left flex-1">
                                    <li>Browse the menu</li>
                                    <li>Add to cart</li>
                                    <li>Place your order</li>
                                    <li>Track delivery</li>
                                    <li>Enjoy your meal</li>
                                </ul>
                                <p class="font-poppins text-gray-700 text-lg italic mt-6 text-left">Simple steps to get your favorite meals delivered quickly and hassle-free.</p>
                            </div>
                        </section>
                    </div>
                </section>

                <!-- community & customers -->
                <section class="text-center bg-amber-500 p-12 rounded-lg shadow-md max-w-4xl mx-auto mb-4">
                    <h3 class="font-merriweather text-2xl font-bold text-gray-900 mb-2">Community & Customers</h3>
                    <p class="font-poppins text-gray-700 text-lg mb-2">Every order supports local cooks, local suppliers, and the tradition of Filipino dining.</p>
                </section>

                <!-- CTA -->
                <div class="pt-4 flex justify-center mb-2">
                    <x-menuButton href="/order">Order Now</x-menuButton>
                </div>
            </div>
        </section>
    </div>

    <x-footer />
</x-layout>