<x-pdm-layout title="{{ config('appconstants.app.name') }}">

    <section class="section">

        <div class="columns">

            <div class="column is-4 ">
                <p class="title has-text-weight-light is-size-1">Be Agile<br>Run Agile</p>
                <p class="subtitle is-size-4">{{ config('appconstants.app.name') }}</p>

                {{-- <figure class="image my-4">
                    <img src="images/masttech_pdm.svg" alt="Company PDM">
                </figure> --}}


                <article class="message  has-background-white">
                <div class="message-body">
                    <strong>Data-Driven Success</strong><br><br>
                        PDM empowers businesses by organizing, tracking, and optimizing product-related data. Success lies in harnessing this data effectively.
                </div>
                </article>

                <article class="message has-background-white">
                <div class="message-body">
                    <strong>Data Make Sense</strong><br><br>
                    PDM bridges the gap between raw information and actionable insights, leading to successful product development.
                </div>
                </article>

                <article class="message has-background-white">
                    <div class="message-body">
                        <strong>Order in Your Data World</strong><br><br>
                        PDM brings structure and clarity, ensuring seamless collaboration across teams.
                    </div>
                </article>

            </div>

            <div class="column">

                @if(Auth::check())

                    <livewire:lw-stats />


                @else 
                    <figure class="image my-0 mx-6">
                        <img src="images/pdmhero.svg" alt="PDM Hero">
                    </figure>
               @endif 
            </div>
        </div>

    </section>

</x-pdm-layout>

