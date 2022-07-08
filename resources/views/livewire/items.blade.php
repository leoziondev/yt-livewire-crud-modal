<div class="bg-white">
    <div class="p-4 text-xl font-bold">
        Items
    </div>
    <div>
        <div class="flex justify-between items-center p-4">
            <div>
                <input
                    wire:model.debounce.500ms="q"
                    type="search"
                    placeholder="search"
                    class="rounded-md border-gray-300"
                />
            </div>
            <div>
                <input wire:model="active" type="checkbox" class="leading-tight" /> Active Only?
            </div>
        </div>
        <table class="table-auto w-full">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="text-md font-bold text-gray-700 p-4">ID</th>
                    <th class="text-md font-bold text-gray-700 p-4">Name</th>
                    <th class="text-md font-bold text-gray-700 p-4">Price</th>
                    @if(!$active)
                    <th class="text-md font-bold text-gray-700 p-4">Status</th>
                    @endif
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr class="border-t border-gray-100">
                    <td class="px-4 py-2">{{ $item->id }}</td>
                    <td class="px-4 py-2">{{ $item->name }}</td>
                    <td class="px-4 py-2">{{ number_format($item->price, 2)}}</td>
                    @if(!$active)
                    <td class="px-4 py-2">{{ $item->status ? 'Active' : 'Not-Active' }}</td>
                    @endif
                    <td class="px-4 py-2 flex justify-end"> edit delete</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $items->links() }}
        </div>
    </div>
</div>
