@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-4">
        <ul class="inline-flex items-center space-x-1 text-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-1 rounded bg-gray-200 text-gray-500 cursor-not-allowed">&lsaquo;</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-1 rounded bg-white border text-gray-700 hover:bg-gray-100">
                        &lsaquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-3 py-1 rounded text-gray-500">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-1 rounded bg-blue-600 text-white font-bold shadow">{{ $page }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-3 py-1 rounded bg-white border text-gray-700 hover:bg-gray-100">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-1 rounded bg-white border text-gray-700 hover:bg-gray-100">
                        &rsaquo;
                    </a>
                </li>
            @else
                <li class="px-3 py-1 rounded bg-gray-200 text-gray-500 cursor-not-allowed">&rsaquo;</li>
            @endif
        </ul>
    </nav>
@endif
