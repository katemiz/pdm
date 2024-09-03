<section class="mx-auto bg-white-100 ">

    <div class="container flex flex-col md:flex-row mx-auto px-4">

        <div class="flex flex-col md:w-1/3 m-4">

            <livewire:header type="Hero" title="Be Agile<br>Run Agile" subtitle="Product Data Management"/>

            <div class="flex flex-col w-full mx-auto gap-4">
                @foreach ($mottos as $motto)
                    <div class="mx-auto rounded-xl shadow-lg overflow-hidden">
                        <div class="xl:flex">
                            <div class="md:shrink-0 bg-blue-50">
                                <img class="h-48 w-full object-scale-down md:h-full md:w-48" src="{{asset("/images/".$motto['img'])}}" alt="Modern building architecture">
                            </div>
                            <div class="p-8 bg-gray-100 shadow-md bg-opacity-70 ">
                                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{$motto['title']}}</div>
                                <p class="mt-2 text-slate-500">{{$motto['content']}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        @if(Auth::check())

            <div class="w-full md:w-2/3 p-4 items-center justify-center">
                <livewire:pdm-stats />
            </div>

        @else

            <div style="background-image: url('{{ asset('/images/HeroPage3.png') }}');" class="w-full md:w-2/3 p-4 items-center justify-center bg-cover bg-center bg-no-repeat">
                <h2 class="text-white text-6xl font-extrabold text-center py-32">{{ config('appconstants.kapkara.motto') }}</h2>
            </div>

        @endif

    </div>

</section>
