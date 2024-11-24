@if (count($revisions) > 1)

    <div class="flex flex-row justify-between">

        <nav class="flex flex-col text-gray-700" aria-label="Breadcrumb">

            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">

                @foreach ($revisions as $key => $revision)

                    <li class="inline-flex items-center">

                        @if ($key != 0)
                            <x-carbon-chevron-right class="w-4 h-4 text-gray-400" />
                        @endif

                        <a wire:click="showRevision({{ $revision['id'] }})"
                            class="inline-flex items-center cursor-pointer text-base text-blue-600 hover:text-blue-600 {{ $key != 0 ? 'ml-4':''}} {{ $rev == $revision['revision'] ? 'font-extrabold': ''}}">
                            R{{ $revision['revision'] }}
                        </a>

                    </li>

                @endforeach

            </ol>

        </nav>

    </div>

@else
    <!-- No revisions -->
    <div></div>

@endif
