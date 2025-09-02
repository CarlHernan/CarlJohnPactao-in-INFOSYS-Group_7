<nav
    class="bg-transparent backdrop-blur-lg sticky top-0 inset-x-0 z-50 px-6 py-1 md:py-2 flex items-center justify-between font-montserrat border-0 shadow-md">
    <!-- ...rest of your navbar code... -->
    <div class="flex items-center gap-1 mb-1  ">
        <img src="{{ asset('images/logo.png') }}" alt="PingganPH logo" loading="lazy" class="h-6 ">
        <div class="font-bold text-lg mt-2 text-black">Pinggan<span class="text-emerald-800">PH</span></div>
    </div>

    <div class="flex items-center md:gap-8 gap-2 ">
        <div class="hidden md:flex items-center">
            <ul class="flex gap-8 rounded-md px-2 py-1 items-center">
                <li>
                    <a href="/home"
                       class="{{ request()->Is('home') ? 'text-emerald-900 underline underline-offset-3 transform transition-transform duration-150' : 'text-emerald-900 transform transition-transform duration-150 hover:scale-110 inline-block ' }} ">Home</a>
                </li>
                <li>
                    <a href="/menu"
                       class="{{ request()->Is('menu*') ? 'text-emerald-900 underline underline-offset-3 transform transition-transform duration-150' : 'text-emerald-900 inline-block transform transition-transform duration-150 hover:scale-110' }}">Menu</a>
                </li>
                <li>
                    <a href="/orders"
                       class="{{ request()->Is('orders*') ? 'text-emerald-900 underline underline-offset-3 transform transition-transform duration-15' : 'text-emerald-900 transform duration-150 hover:scale-110 inline-block' }} ">Orders</a>
                </li>
                <li>
                    <a href="/about"
                       class="{{ request()->Is('about*') ? 'text-emerald-900 underline underline-offset-3 transform transition-transform duration-15' : 'text-emerald-900 transform duration-150 hover:scale-110 inline-block' }} ">About</a>
                </li>
            </ul>
        </div>


    </div>

    <div class="flex items-center ">
        <button class="text-emerald-900 md:border-hidden border-r-1 border-gray-300 pr-1">
            @include('components.icons.cart')
        </button>
        <button id="menuBtn" class="md:hidden pl-1  text-emerald-900 border-black">
            @include('components.icons.hamburger')
        </button>

    </div>
    <div id="navModal" class="hidden fixed inset-0 z-40">
        {{-- para kung i tap mag close yung modal, no need i click yung close button --}}
        <div id="modalBackdrop" class="fixed inset-0"></div>

        <div class="relative top-12 ml-auto rounded-lg mr-5 w-4/10 bg-white text-gray-900 shadow-lg p-4 max-h-fit">
            <button id="closeBtn" class="absolute top-3 right-3">
                @include('components.icons.close')
            </button>
            <nav class="mt-6">
                <ul class="space-y-3">
                    <li><a href="/" class="block px-2 py-1 rounded hover:bg-gray-100 text-left">Home</a></li>
                    <li><a href="#" class="block px-2 py-1 rounded hover:bg-gray-100 text-left">Products</a></li>
                    <li><a href="#" class="block px-2 py-1 rounded hover:bg-gray-100 text-left pb-auto">Orders</a></li>
                </ul>
            </nav>
        </div>
    </div>

</nav>

<script>

    // lezgo  back to vanilla
    document.addEventListener('DOMContentLoaded', () => {
        const navModal = document.querySelector("#navModal");
        const menuBtn = document.querySelector("#menuBtn");
        const closeBtn = document.querySelector("#closeBtn");
        const modalBackdrop = document.querySelector("#modalBackdrop");

        menuBtn.addEventListener('click', () => {
            navModal.classList.remove('hidden');
            navModal.classList.add('flex');
        });

        closeBtn.addEventListener('click', () => {
            navModal.classList.add('hidden');
        });

        modalBackdrop.addEventListener('click', () => {
            navModal.classList.add('hidden');
        });
    });

</script>
