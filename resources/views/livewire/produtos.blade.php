<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produtos') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex mb-5">
                <x-button wire:click.prevent="edit" class="float-right">
                    {{ __('Create Produto') }}
                </x-button>
            </div>
            <x-table wire:loading.class="opacity-75">
                <x-slot name="header">
                    <x-table.header>No.</x-table.header>
                    <x-table.header sortable wire:click.prevent="sortBy('nome')" :direction="$sortField === 'nome' ? $sortDirection : null">Nome</x-table.header>
                    <x-table.header sortable wire:click.prevent="sortBy('descricao')" :direction="$sortField === 'descricao' ? $sortDirection : null">Descricao</x-table.header>
                    <x-table.header sortable wire:click.prevent="sortBy('preco')" :direction="$sortField === 'preco' ? $sortDirection : null">Preco</x-table.header>
                    <x-table.header sortable wire:click.prevent="sortBy('stock')" :direction="$sortField === 'stock' ? $sortDirection : null">Stock</x-table.header>
                    <x-table.header>Action</x-table.header>
                </x-slot>
                <x-slot name="body">
                    @php
                        $i = (request()->input('page', 1) - 1) * $perPage;
                    @endphp
                    @forelse ($records as $key => $record)
                        <x-table.row>
                            <x-table.cell> {{ ++$i }}</x-table.cell>
                            <x-table.cell>{{ $record->name }}</x-table.cell>
                            <x-table.cell> {{ $record->descricao }}</x-table.cell>
                            <x-table.cell> {{ $record->preco }}</x-table.cell>
                            <x-table.cell> {{ $record->stock }}</x-table.cell>
                            <x-table.cell>
                                <button wire:click="edit('{{ $record->id }}')"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                                <button wire:click="deleteId('{{ $record->id }}')"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan=4>
                                <div class="flex justify-center items-center">
                                    <span class="font-medium py-8 text-gray-400 text-xl">
                                        No data found...
                                    </span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>
            @if ($records->hasPages())
                <div class="p-3">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <x-modals.form wire:model.live="isFormOpen">
        <x-slot name="title">
            {{ __('Add/Edit Record') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="nome" value="{{ __('Nome') }}" />
                <x-input id="nome" type="text" class="mt-1 block w-full" wire:model="nome" />
                <x-input-error for="nome" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="descricao" value="{{ __('Descricao') }}" />
                <x-input id="descricao" type="text" class="mt-1 block w-full" wire:model="descricao" />
                <x-input-error for="descricao" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="preco" value="{{ __('Preco') }}" />
                <x-input id="preco" type="number" class="mt-1 block w-full" wire:model="preco" />
                <x-input-error for="preco" class="mt-2" />
            </div>
            div class="col-span-6 sm:col-span-4">
                <x-label for="stock" value="{{ __('Stock') }}" />
                <x-input id="stock" type="number" class="mt-1 block w-full" wire:model="stock" />
                <x-input-error for="stock" class="mt-2" />
            </div>
        </x-slot>
    </x-modals.form>
    <!-- Delete Confirmation Modal -->
    <x-confirmation-modal wire:model.live="isDeleteModalOpen">
        <x-slot name="title">
            {{ __('Delete Record') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this record?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click.prevent="closeDelete">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click.prevent="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>