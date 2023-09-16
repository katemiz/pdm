<div class="has-background-grey has-text-white has-text-right pr-3 is-size-7 py-3">
    {{config('constants.company.motto')}} {{ config('appconstants.app.motto') }}
</div>
<footer class="footer has-background-dark">

    <div class="tile is-ancestor">

        <article class="tile is-child notification has-text-centered-mobile">
            <img src="/images/{{config('appconstants.company.logo')}}" width="28px" alt="Company Icon"><br>

            <a href="{{config('constants.company.link')}}" class="has-text-weight-light">{{config('constants.company.name')}}</a>
            <p class="has-text-weight-light is-size-7">{{config('constants.company.motto')}}</p>
        </article>

        <article class="tile is-child notification has-text-centered my-6 is-2">
            <p class="has-text-weight-light is-hidden-mobile">{{config('constants.app.title')}}</p>

            <figure class="image is-inline-block" >
            {{-- <img class="mt-3 mt-1-mobile pt-3 pt-1-mobile" src="/images/{{config('constants.app.app_footer_logo')}}" alt="App Logo"> --}}
            <x-carbon-model-alt />
            </figure>
        </article>

        <article class="tile is-child notification">
            <p class="has-text-weight-light has-text-right has-text-centered-mobile">{{config('constants.app.copyright')}}</p>
            <p class="has-text-weight-light has-text-right has-text-centered-mobile is-size-7">{{config('constants.app.version')}}</p>
        </article>

    </div>

</footer>
