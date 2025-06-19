{{-- File: resources/views/livewire/mat-family-manager.blade.php --}}

<div class="section container">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Material Families</h1>
        <p class="subtitle has-text-weight-light">Manage broad categories of materials like steel, aluminum, plastics, etc.</p>
    </div>




    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="notification is-success is-light">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    @endif




    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">

            {{-- Add Button --}}
            <button wire:click="create" class="button is-dark">
                <span class="icon is-small"><x-carbon-add /></span>
                <span>Add Family</span>
            </button>

        </div>

        <!-- Right side -->
        <div class="level-right">

            <div class="field has-addons">

                <div class="control">
                    <input type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search families..."
                        class="input">
                </div>

                <div class="control">
                <button class="button is-static">
                    @if ( strlen($search) > 0)
                        <span class="icon is-small" wire:click="resetSearch">
                            <x-carbon-close />
                        </span>
                    @else
                        <span class="icon is-small">
                            <x-carbon-search />
                        </span>
                    @endif
                </button>
                </div>
            </div>

        </div>

    </nav>






    {{-- Form Modal --}}
    @if($showForm)
        {{-- <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="cancel">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white" wire:click.stop> --}}


                <h3 class="subtitle has-text-link mb-24">
                    {{ $editingId ? 'Edit Material Family' : 'Add New Material Family' }}
                </h3>


                <div class="card p-6">

                    <form wire:submit="save">

                        <div class="columns">

                            {{-- Name Field --}}
                            <div class="column field is-half">

                                <label for="name" class="label">
                                    Family Name <span class="text-red-500">*</span>
                                </label>

                                <div class="control">
                                    <input type="text" 
                                        id="name"
                                        wire:model="name"
                                        class="input"
                                        placeholder="e.g., Steel, Aluminum">
                                    @error('name')
                                        <p class="has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>


                            {{-- Name Field --}}
                            <div class="column field is-half">

                                <label for="code" class="label">
                                    Family Code <span class="text-red-500">*</span>
                                </label>

                                <div class="control">
                                    <input type="text" 
                                        id="code"
                                        wire:model="code"
                                        class="input"
                                        placeholder="e.g., STL, ALU">
                                    @error('code')
                                        <p class="has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                        </div>



                        <div class="columns">

                            {{-- Description Field --}}
                            <div class="column field">
                                <label for="description" class="label">
                                    Description
                                </label>
                                <textarea id="description"
                                        wire:model="description"
                                        rows="3"
                                        class="textarea"
                                        placeholder="Brief description of the material family"></textarea>
                                @error('description')
                                    <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>


                        <div class="columns">

                            {{-- Active Status --}}
                            <div class="column field is-half">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                        wire:model="is_active"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Active</span>
                                </label>
                            </div>


                            {{-- Form Actions --}}
                            <div class="column is-half buttons has-text-right">

                                {{-- Delete Button --}}
                                <button type="button" 
                                        wire:click="cancel"
                                        class="button">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="button is-link">
                                    {{ $editingId ? 'Update' : 'Create' }}
                                </button>
                            </div>

                        </div>



                    </form>
                </div>
            {{-- </div>
        </div> --}}
    @endif

    {{-- Data Table --}}
    <div class="box">
        <div class="overflow-x-auto">
            <table class="table is-striped is-fullwidth">
                <thead>
                    <tr>
                        <th>

                            <div class="is-flex is-justify-content-space-between is-align-items-center" wire:click="sortBy('name')">
                                
                                <span>Name</span>

                                <span class="icon">
                                    @if($sortField === 'name')

                                        @if($sortDirection === 'asc')
                                            <x-carbon-chevron-down />
                                        @else
                                            <x-carbon-chevron-up />
                                        @endif

                                    @else
                                        <x-carbon-chevron-sort />
                                    @endif
                                </span>

                            </div>

                        </th>


                        <th>

                            <div class="is-flex is-justify-content-space-between is-align-items-center" wire:click="sortBy('code')">

                                <span>Code</span>

                                <span class="icon">

                                    @if($sortField === 'code')

                                        @if($sortDirection === 'asc')
                                            <x-carbon-chevron-down />
                                        @else
                                            <x-carbon-chevron-up />
                                        @endif

                                    @else
                                        <x-carbon-chevron-sort />
                                    @endif

                                </span>

                            </div>

                        </th>

                        <th>Description</th>
                        <th>Materials</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($families as $family)

                        <tr>

                            <td>{{ $family->name }}</td>
                            <td>{{ $family->code }}</td>
                            <td title="{{ $family->description }}">{{ $family->description ?: '-' }}</td>
                            <td>{{ $family->materials_count }}</td>

                            <td>
                                <button wire:click="toggleStatus({{ $family->id }})" class="{{ $family->is_active ? 'is-active' : '' }}">
                                    {{ $family->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>

                            <td>
                                <a class="icon" wire:click="edit({{ $family->id }})" title="Edit"><x-carbon-pen /></a>
                                <a class="icon has-text-danger" wire:click="delete({{ $family->id }})" title="Delete" wire:confirm="Are you sure you want to delete this user?"><x-carbon-trash-can /></a>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="flex flex-col items-center">
                                    <p class="text-lg font-medium">No material families found</p>
                                    <p class="text-sm text-gray-400 mb-4">Get started by creating your first material family.</p>

                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($families->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $families->links() }}
            </div>
        @endif
    </div>
</div>
