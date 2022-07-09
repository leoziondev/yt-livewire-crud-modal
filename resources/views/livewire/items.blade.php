<div class="bg-white">
    <div class="p-4 flex items-center justify-between">
        <span class="text-xl font-bold">Items</span>
        <x-jet-button wire:click="confirmItemAdd" class="bg-indigo-500 hover:bg-indigo-400">Add Item</x-jet-button>
        {{-- <br>{{ $query }} --}}
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
                    <th class="text-md font-bold text-gray-700 p-4">
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">ID</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="text-md font-bold text-gray-700 p-4">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Name</button>
                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="text-md font-bold text-gray-700 p-4">
                        <div class="flex items-center">
                            <button wire:click="sortBy('price')">Price</button>
                            <x-sort-icon sortField="price" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    @if(!$active)
                    <th class="text-md font-bold text-gray-700 p-4">
                        <div class="flex items-center">
                            <button wire:click="sortBy('status')">Status</button>
                            <x-sort-icon sortField="status" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
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
                    <td class="px-4 py-2 flex justify-end">
                        {{-- <button class="bg-gray-100 rounded-md p-2 mr-2 text-gray-400 hover:text-gray-600" wire:click="confirmItemEdit" wire:loading.attr="disabled">
                            <x-icons.edit />
                        </button> --}}
                        <button wire:click="confirmItemDelete({{ $item->id }})" wire:loading.attr="disabled" class="bg-gray-100 rounded-md p-2 mr-2 text-gray-400 hover:text-white hover:bg-red-500">
                            <x-icons.trash />
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $items->links() }}
        </div>
    </div>

    <x-jet-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ __('Add Item') }}
        </x-slot>

        <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-2">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 mb-2">
                    <x-jet-label for="price" value="{{ __('Price') }}" />
                    <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="price" />
                    <x-jet-input-error for="price" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 mb-2">
                    <label for="status" value="{{ __('Status') }}">
                        <input type="checkbox" class="form-checkbox" wire:model.defer="status" />
                        <span class="ml-2 text-sm text-gray-600">Active</span>
                    </label>
                </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="bg-indigo-500 hover:bg-indigo-400 ml-3" wire:click="saveItem()" wire:loading.attr="disabled">
                {{ __('Add Item') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="confirmingItemDelete">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this Item <strong>ID: {{ $confirmingItemDelete }}</strong>? This action is irreversible, please attention!
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemDelete', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteItem({{ $confirmingItemDelete }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
