<nav
    class="bg-transparent backdrop-blur-lg sticky top-0 inset-x-0 z-50 px-6 py-1 md:py-2 flex items-center justify-between font-montserrat border-0 shadow-md">
    <!-- ...rest of your navbar code... -->
    <a href="/home" class="flex items-center gap-1 mb-1" aria-label="Go to homepage">
        <img src="{{ asset('images/logo.png') }}" alt="PingganPH logo" loading="lazy" class="h-6">
        <div class="font-bold text-lg mt-2 text-black">Pinggan<span class="text-emerald-800">PH</span></div>
    </a>

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


        {{--Ito yung modal para sa navlinks sa mobile if gusto nyu mag add nang desing go lng--}}
            <div id="navModal" class="hidden fixed inset-0 z-40 flex flex-col">

                <div id="modalBackdrop" class="absolute inset-0"></div>


                <div class="relative w-full bg-gray-100 shadow-md flex flex-col items-center py-10 animate-slideDown">

                    <button id="closeBtn" class="absolute top-5 right-6 text-2xl">
                        @include('components.icons.close')
                    </button>


                    <nav class="mt-10">
                        <ul class="text-2xl font-semibold text-gray-900 space-y-8 text-center">
                            <li class="nav-link opacity-0"><a href="/home" class="block hover:text-emerald-700">Home</a></li>
                            <li class="nav-link opacity-0"><a href="/menu" class="block hover:text-emerald-700">Products</a></li>
                            <li class="nav-link opacity-0"><a href="/orders" class="block hover:text-emerald-700">Orders</a></li>
                            <li class="nav-link opacity-0"><a href="/about" class="block hover:text-emerald-700">About</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

    </div>




</nav>

<script>
            //Hastag i love vanila ^^
        document.addEventListener('DOMContentLoaded', () => {
            const navModal = document.querySelector("#navModal");
            const menuBtn = document.querySelector("#menuBtn");
            const closeBtn = document.querySelector("#closeBtn");
            const navLinks = document.querySelectorAll("#navModal .nav-link");

            menuBtn.addEventListener('click', () => {
                navModal.classList.remove('hidden');
                navModal.classList.add('show');

                //Ito yung pa isa isa sila naga baba
                navLinks.forEach((link, i) => {
                    setTimeout(() => {
                        link.classList.add('show');
                    }, i * 200);
                });
            });

            closeBtn.addEventListener('click', () => {
                navModal.classList.add('hidden');
                navModal.classList.remove('show');
                navLinks.forEach(link => link.classList.remove('show'));
            });
        });


</script>
