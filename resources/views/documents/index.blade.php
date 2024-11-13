<section class="container mx-auto p-4">

    <script src="{{ asset('/js/confirm_modal.js') }}"></script>

    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <livewire:header type="Page" title="{{ $constants['list']['title'] }}" subtitle="{{ $constants['list']['subtitle'] }}"/>
        </div>

        <div class="">
            <input type="checkbox" wire:model="show_latest" wire:click="$toggle('show_latest')"> Show only latest revisions
        </div>
    </div>


    @if(session('msg'))
        <livewire:flash-message :msg="session('msg')">
    @endif


    @if ($documents->count() > 0)

        <livewire:datatable-search add_command="Add Document" />

        <div class="relative overflow-x-auto my-4">

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg">

                <caption class="caption-top py-4">
                    {{ $documents->total() }} {{ $documents->total() > 1 ? ' Records' :' Record' }}
                </caption>

                <thead class="text-gray-700 font-light bg-slate-200">
                <tr>
                    @foreach ($datatable_props as $prop)

                        @if ($prop['visibility'])
                        <th scope="col" class="px-4 py-2">
                            <div class="flex items-center text-base">

                                {{ $prop['label'] }}

                                @if ($prop['sortable'])
                                    <a href="#"><x-carbon-chevron-sort class="w-3 h-3 ms-1.5"/></a>
                                @endif
                            </div>
                        </th>
                        @endif

                    @endforeach

                    @if ($hasActions)
                        <th scope="col" class="px-4 py-2 text-right text-base">Actions</th>
                    @endif
                </tr>
                </thead>

                <tbody>
                    @foreach ($documents as $record)

                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                            @foreach ($datatable_props as $key => $prop)

                                @if ($prop['visibility'])
                                    <td class="px-4 py-2 text-base {{ !$prop['wrapText'] ? 'whitespace-nowrap':'' }}">

                                        @if ($prop['hasViewLink'])
                                            <a href="/docs/{{ $record->id }}" class="inline-flex text-blue-700">
                                                {{ $record[$key] }}
                                            </a>
                                        @else
                                            {{ $record[$key] }}
                                        @endif

                                    </td>
                                @endif

                            @endforeach

                            @if ($hasActions)

                                <td scope="col" class="px-4 py-2 text-base text-right whitespace-nowrap">

                                    <a href="/docs/{{ $record->id }}" class="inline-flex text-blue-700">
                                        <x-carbon-view class="w-6 h-6"/>
                                    </a>

                                    @role(['EngineeringDept'])

                                        @if ( !in_array($record->status,['Frozen','Released']) )

                                            <a href="/docs-form/{{ $record->id }}" class="inline-flex text-blue-700">
                                                <x-carbon-edit  class="w-6 h-6 ms-1.5"/>
                                            </a>
                                            {{-- <a wire:click="triggerDelete({{ $record->id }})" class="inline-flex text-red-700">
                                                <x-carbon-trash-can  class="w-6 h-6 ms-1.5"/>
                                            </a> --}}

                                        @endif

                                    @endrole

                                </td>
                            @endif

                        </tr>

                    @endforeach
                </tbody>


            </table>
        </div>

        {{ $documents->links('components.pagination.tailwind') }}

    @else

        <livewire:tablenoitem addtext="Add Document" noitemtext="No documents found in the database!"/>

    @endif




    <script>

        window.addEventListener('queryChanged', e => {
            Livewire.dispatch('startQuerySearch', {query:event.detail.query});
        });

        window.addEventListener('addTriggered', e => {
            window.location.href = "/docs-form"
        });

    </script>
</section>


