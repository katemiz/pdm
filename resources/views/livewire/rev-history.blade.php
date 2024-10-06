@if (count($revisions) > 1)




    <div class="flex flex-row justify-between">

        <div class="uppercase text-sm text-gray-600">Revision History</div>
        <div class="flex">

            <nav class="flex flex-col text-gray-700" aria-label="Breadcrumb">

                <label for="revisions" class="uppercase text-sm text-gray-600">Revision History</label>

                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">

                    @foreach ($revisions as $key => $revision)

                        @if ($key == 0)

                            <li class="inline-flex items-center">
                                <a wire:click="showRevision({{ $revision['id'] }})"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    R{{ $revision['revision'] }}
                                </a>
                            </li>

                        @else

                            <li>
                                <div class="flex items-center">
                                    <x-carbon-chevron-right class="w-4 h-4" />
                                    <a wire:click="showRevision({{ $revision['id'] }})"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                        R{{ $revision['revision'] }}
                                    </a>
                                </div>
                            </li>

                        @endif
                    @endforeach

                </ol>

            </nav>


        </div>


    </div>



@else
    <!-- No revisions -->
    <div></div>

@endif
