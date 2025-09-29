<x-layout >
    <div class="min-h-screen w-screen overflow-y-auto flex flex-col ">
        <section
            class="pb-14 min-h-screen relative flex flex-col bg-stone-300 bg-gradient-to-b from-white/50 to-black/50 bg-blend-soft-light items-center jmd:p-0ustify-center pt-16 text-center gap-8 p-0 md:px-6">
            <h1 class="text-emerald-900 font-bold text-5xl font-merriweather md:text-3xl lg:text-6xl max-w-6xl">PingganPH<span class="hidden md:inline-block">:&nbsp;</span><span class="hidden md:inline-block lg:show">Simply The Best
                Karinderya in Kabacan!</span></h1>
            <h2 class="lg:text-2xl  font-bold ">Todays Paboritos:</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featured as $products)
                <x-components.homepage-product-card
                    :dish_name="$products->dish_name"
                    :price="$products->price"
                    :description="$products->description"
                    :image_path="asset('storage/' . $products->image_path)"/>
                @endForEach
            </div>
        </section>

        <section class=" bg-amber-500 front py-12 px-6 lg:px-20 flex flex-col lg:flex-row items-center lg:items-start gap-10">
            <div class="lg:w-1/2 space-y-6">
                <h1 class="font-merriweather text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight">Your Favorite
                    Karinderya, Now Online.</h1>

                <p class="font-poppins text-gray-700 text-xl">Enjoy homestyle meals made simple. Order anytime,
                    anywhere—fresh, affordable, and cooked just like home.</p>

                <ul class="space-y-4 text-xl font-merriweather text-gray-800">
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

                <div class="pt-4">
                    <x-menuButton href="/menu">View Menu</x-menuButton>
                </div>
            </div>

            <div class="flex-col justify-center items-center max-w-1/2 hidden lg:flex">
                <img src="{{asset('/images/heroFInalnt.png')}}" alt="Food" class="w-full h-full object-cover">
            </div>
        </section>

    </div>
    <x-footer/>
</x-layout>


