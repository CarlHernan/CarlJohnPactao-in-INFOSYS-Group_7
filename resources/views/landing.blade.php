<x-layout title="QuickCart" full>
    <div class="min-h-screen w-screen overflow-y-auto flex flex-col gap-4">
        <section
            class="min-h-screen relative flex flex-col items-center justify-center pt-16 text-center gap-8 p-0 md:px-6 md:p-0">
            <h1 class="text-emerald-900 text-2xl md:text-3xl lg:text-6xl max-w-6xl mt-8 ">PingganPH: Simply The Best
                Karinderya in Kabacan!</h1>
            <h2 class="lg:text-2xl  font-bold ">Todays Paboritos:</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


            </div>
        </section>

        <section class=" bg-amber-500 front py-12 px-6 lg:px-20 flex flex-col lg:flex-row items-center lg:items-start gap-10">
            <!-- Left Content -->
            <div class="lg:w-1/2 space-y-6">
                <!-- Headline -->
                <h1 class="font-merriweather text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">Your Favorite
                    Karinderya, Now Online.</h1>

                <!-- Subheadline -->
                <p class="font-poppins text-gray-700 text-lg">Enjoy homestyle meals made simple. Order anytime,
                    anywhere—fresh, affordable, and cooked just like home.</p>

                <!-- List -->
                <ul class="space-y-4 text-lg font-merriweather text-gray-800">
                    <li class="flex items-start gap-3">
                        <span class="text-xl">*</span>
                        <span>Easy Ordering – Browse our menu and order in just a few clicks.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-xl">*</span>
                        <span>Convenience at Your Fingertips – Skip the line, your food is just a tap away.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-xl">*</span>
                        <span>Track Your Orders – See real-time updates from kitchen to doorstep.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-xl">*</span>
                        <span>No More Sunburn Meals – Beat the heat, stay comfy at home while we deliver your ulam.</span>
                    </li>
                </ul>

                <!-- Button -->
                <div class="pt-4">
                    <x-menuButton href="/menu e">View Menu</x-menuButton>
                </div>
            </div>

            <!-- Right Images -->
            <div class="flex flex-col justify-center items-center max-w-1/2">
                <img src="{{asset('/images/heroFInalnt.png')}}" alt="Food" class="w-full h-full object-cover">
            </div>
        </section>

    </div>
    <x-footer/>
</x-layout>


<script>

</script>
