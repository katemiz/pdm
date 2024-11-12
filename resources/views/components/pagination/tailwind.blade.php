@if ($paginator->hasPages())

<div class="flex items-center justify-between py-3">


    {{-- For Mobile Views Only --}}
    <div class="flex flex-1 justify-between sm:hidden">
      <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">{!! __('pagination.previous') !!}</a>
      <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">{!! __('pagination.next') !!}</a>
    </div>


    {{-- Page Links --}}
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">

      <div>
        <p class="text-sm text-gray-700">
          [<span class="font-medium">{{ $paginator->firstItem() }}</span> - <span class="font-medium">{{ $paginator->lastItem() }}</span>] {!! __('of') !!}
          <span class="font-medium">{{ $paginator->total() }}</span>
          {!! __('results') !!}
        </p>
      </div>


      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">

          {{-- Previous Page Link --}}
          <a href="#" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
            <span class="sr-only">Previous</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
              <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
            </svg>
          </a>



          @foreach ($elements as $element)

            {{-- "Three Dots" Separator --}}
            @if (is_string($element))

                <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">
                    &hellip;
                </span>

            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)

                    <a wire:click="setPage({{ $page}})"
                        aria-current="page"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold {{ $page == $paginator->currentPage() ? 'bg-indigo-600 text-white':'' }} text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        {{ $page }}
                    </a>

                @endforeach
            @endif

        @endforeach





          {{-- Next Page Link --}}
          <a href="#" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
            <span class="sr-only">Next</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
              <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
          </a>

        </nav>
      </div>
    </div>
  </div>

  @endif
