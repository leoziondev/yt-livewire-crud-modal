@props(['sortBy', 'sortAsc', 'sortField'])

<div class="flex flex-col ml-2 text-gray-300">
    <x-icons.sort-up class="w-3 h-3 {{ $sortBy == $sortField && $sortAsc ? 'text-gray-600' : '' }}" />
    <x-icons.sort-down class="w-3 h-3 -mt-1 {{ $sortBy == $sortField && !$sortAsc ? 'text-gray-600' : '' }}" />
</div>
