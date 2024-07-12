<div class="has-background-grey-lighter has-text-black has-text-right pr-3 is-size-7 py-1 my-0">
    {{config('constants.company.motto')}} {{ config('appconstants.app.motto') }}
</div>

<footer class="footer has-background-dark ">

    <div class="columns">

        <div class="column is-4 has-text-centered-mobile">
            <img src="/images/{{config('appconstants.kapkara.logo')}}" width="28px" alt="Company Icon"><br>

            <a href="{{config('appconstants.kapkara.link')}}" class="has-text-weight-light has-text-white">{{config('appconstants.kapkara.name')}}</a>
            <p class="has-text-warning has-text-weight-light is-size-7">{{config('appconstants.kapkara.motto')}}</p>
        </div>

        <div class="column is-4 has-text-centered my-6 is-2">
            <p class="has-text-weight-light is-hidden-mobile has-text-white">{{config('appconstants.app.name')}}</p>
            <span class="icon is-large has-text-link"><x-carbon-model-alt /></span>
        </div>

        <div class="column is-4 has-text-white">
            <p class="has-text-weight-light has-text-right has-text-centered-mobile">{{config('appconstants.app.copyright')}}</p>
            <p class="has-text-weight-light has-text-right has-text-centered-mobile is-size-7">{!!config('appconstants.app.version')!!}</p>
        </div>

    </div>

</footer>
