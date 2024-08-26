<section class="mx-auto bg-white-100">

    <div class="container flex flex-col md:flex-row mx-auto px-4">

        <div class="flex flex-col md:w-1/3 m-4">

            <livewire:header type="Hero" title="Be Agile<br>Run Agile" subtitle="Product Data Management"/>

            <div class="flex flex-col w-full mx-auto gap-4">
                @foreach ($mottos as $motto)
                    <div class="mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="xl:flex">
                            <div class="md:shrink-0 bg-blue-50">
                                <img class="h-48 w-full object-cover object-scale-down md:h-full md:w-48" src="{{asset("/images/".$motto['img'])}}" alt="Modern building architecture">
                            </div>
                            <div class="p-8 bg-gray-100 shadow-md">
                                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{$motto['title']}}</div>
                                <p class="mt-2 text-slate-500">{{$motto['content']}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="w-full md:w-2/3 p-4">

            @if(Auth::check())
                <livewire:pdm-stats />
            @else

                <div class="relative max-w-xl mx-auto">
                    <img class="" src="{{asset("/images/HeroPage1.png")}}" alt="PDM Future">
                    <div class="absolute inset-0 bg-gray-700 opacity-0 rounded-md"></div>
                    <div class="absolute inset-0 flex content-end justify-center">
                        <h2 class="text-white text-6xl font-light">{{ config('appconstants.kapkara.motto') }}</h2>
                    </div>
                </div>

            @endif
        </div>


    </div>

</section>
