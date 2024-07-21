<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Compras') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex mb-5">
                <x-button wire:click.prevent="edit" class="float-right">
                    {{ __('Create Compra') }}
                </x-button>
            </div>
            <x-table wire:loading.class="opacity-75">
                <x-slot name="header">
                    <x-table.header>No.</x-table.header>
                    <x-table.header sortable wire:click.prevent="sortBy('carrinho_id')" :direction="$sortField === 'carrinho_id' ? $sortDirection : null">Carrinho</x-table.header>
                    <x-table.header sortable wire:click.prevent="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">User</x-table.header>
                        <x-table.header sortable wire:click.prevent="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">Status</x-table.header>
                    <x-table.header>Action</x-table.header>
                </x-slot>
                <x-slot name="body">
                    @php
                        $i = (request()->input('page', 1) - 1) * $perPage;
                    @endphp
                    @forelse ($records as $key => $record)
                        <x-table.row>
                            <x-table.cell> {{ ++$i }}</x-table.cell>
                            <x-table.cell>{{ $record->carrinho_id }}</x-table.cell>
                            <x-table.cell>{{ $record->carrinho->user->name }}</x-table.cell>
                            <x-table.cell>{{ $record->status }}</x-table.cell>
                            <x-table.cell>
                                <button wire:click="edit('{{ $record->id }}')"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                                <button wire:click="deleteId('{{ $record->id }}')"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan=7>
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
                <x-label for="carrinho_id" value="{{ __('Carrinho') }}" />
                <x-select id="carrinho_id" class="mt-1 block w-full" wire:model="carrinho_id">
                    <option value="">{{ __('Select Carrinho') }}</option>
                    @foreach(App\Models\Carrinho::with('user')->get() as $carrinho)
                        <option value="{{ $carrinho->id }}">{{ $carrinho->user->name }} (Id: {{ $carrinho->id }} )</option>
                    @endforeach
                </x-select>
                <x-input-error for="carrinho_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="user_id" value="{{ __('User') }}" />
                <x-select id="user_id" class="mt-1 block w-full" wire:model="user_id">
                    <option value="">{{ __('Select User') }}</option>
                    @foreach(App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="user_id" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="status" value="{{ __('Status') }}" />
                <x-select id="status" class="mt-1 block w-full" wire:model="status">
                    <option value="">{{ __('Select Status') }}</option>
                        <option value="Pendente">Pendente</option>
                        <option value="Em Andamento">Em andamento</option>
                        <option value="Finalizado">Finalizado</option>
                        <option value="Cancelado">Cancelado</option>
                </x-select>
                <x-input-error for="user_id" class="mt-2" />
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