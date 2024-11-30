<section class="container mx-auto p-4">

    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <livewire:header type="Hero" title="{{ config('conf_users.index.title') }}" subtitle="{{ config('conf_users.index.subtitle') }}"/>
        </div>

        <div class="">
            <input type="checkbox" wire:model="show_active_only" wire:click="$toggle('show_active_only')"> Show Only Active Users
        </div>
    </div>


    @if(session('msg'))
        <livewire:flash-message :msg="session('msg')">
    @endif


    <livewire:datatable-search :addBtnTitle="config('conf_users.index.addBtnTitle')" :addBtnRoute="config('conf_users.form_create.route')"/>



    @if ($users->count() > 0)

        <div class="relative overflow-x-auto my-4">

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg">

                <caption class="caption-top py-4">
                    {{ $users->total() }} {{ $users->total() > 1 ? ' Records' :' Record' }}
                </caption>

                <thead class="text-gray-700 font-light bg-slate-200">
                <tr class="bg-gray-100">
                    @foreach (config('conf_users.table') as $key => $prop)

                        @if ($prop['visibility'])
                        <th class="p-4 border border-gray-200">
                            <div class="flex items-center text-base justify-between">

                                {{ $prop['label'] }}

                                @if ($prop['sortable'])
                                    <a wire:click="sort('{{$key}}')" class="hover:text-orange-600  {{ $key == $sortField ? "text-blue-600" :''}}">
                                        @if ($key == $sortField)

                                            @if ($sortDirection == 'ASC')
                                                <x-ikon name="SortUp" size="L" />
                                            @else
                                                <x-ikon name="SortDown" size="L" />
                                            @endif

                                        @else
                                            <x-ikon name="Sort" size="L" />
                                        @endif
                                    </a>
                                @endif
                            </div>
                        </th>
                        @endif

                    @endforeach

                    @if ($hasActions)
                        <th class="p-4 text-right text-base border border-gray-200">Actions</th>
                    @endif
                </tr>
                </thead>

                <tbody>
                    @foreach ($users as $record)

                        <tr class="bg-white">

                            @foreach (config('conf_users.table') as $key => $prop)

                                @if ($prop['visibility'])
                                    <td class="px-4 py-2 text-base border border-gray-200 {{ !$prop['wrapText'] ? 'whitespace-nowrap':'' }}">

                                        @if ($prop['hasViewLink'])
                                            <a href="/usrs/{{ $record->id }}" class="inline-flex text-blue-700">
                                                {{ $record[$key] }}
                                            </a>
                                        @else
                                            {{ $record[$key] }}
                                        @endif

                                    </td>
                                @endif

                            @endforeach

                            @if ($hasActions)

                                <td scope="col" class="px-4 py-2 text-base text-right whitespace-nowrap border border-gray-200">

                                    <a href="/usrs/{{ $record->id }}" class="inline-flex text-blue-700">
                                        <x-ikon name="View" size="L"/>
                                    </a>

                                    @role(['EngineeringDept'])

                                        @if ( !in_array($record->status,['Frozen','Released']) )

                                            <a href="/usrs/{{ $record->id }}/edit" class="inline-flex text-blue-700">
                                                <x-ikon name="Edit" size="L"/>
                                            </a>

                                        @endif

                                    @endrole

                                </td>
                            @endif

                        </tr>

                    @endforeach
                </tbody>


            </table>
        </div>

        {{ $users->links('components.pagination.tailwind') }}

    @else

        <livewire:tablenoitem
            :addBtnTitle="config('conf_users.index.addBtnTitle')"
            :addBtnRoute="config('conf_users.form_create.route')"
            :noItemText="config('conf_users.index.noItemText')"/>

    @endif

</section>


