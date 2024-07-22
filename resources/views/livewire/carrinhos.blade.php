<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Meu Carrinho') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- Mensagem de Sucesso -->
        @if (session()->has('success'))
            <div class="alert alert-success mb-4">
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                            </svg>
                        </div>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Button to Open Add Product Modal -->
        <div class="flex mb-5">
            <x-button wire:click.prevent="openAddModal" class="float-right">
                {{ __('Adicionar Produto') }}
            </x-button>

            <x-button wire:click="comprarProduto" class="float-right ml-4">
                {{ __('Efetuar Compra') }}
            </x-button>
        </div>

        <!-- Products Table -->
        <x-table wire:loading.class="opacity-75">
            <x-slot name="header">
                <x-table.header>Produto</x-table.header>
                <x-table.header>Quantidade</x-table.header>
                <x-table.header>Imagem</x-table.header>
                <x-table.header>Ação</x-table.header>
            </x-slot>
            <x-slot name="body">
                @forelse($itens as $item)
                    <x-table.row>
                        <x-table.cell>{{ $item->nome }}</x-table.cell>
                        
                        <x-table.cell>{{ $item->pivot->quantidade }}</x-table.cell>

                        <x-table.cell>
                            <img src="{{ Storage::url($item->imagem) }}" alt="{{ $item->imagem }}" class="h-16 w-16 object-cover">
                        </x-table.cell>
                        <x-table.cell>
                            <button wire:click="removeProduto({{ $item->id }})"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                Remover
                            </button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="4" class="text-center">
                            Nenhum item no carrinho.
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>

        <!-- Pagination -->
        @if ($produtos->hasPages())
            <div class="p-3">
                {{ $produtos->links() }}
            </div>
        @endif
    </div>

    <!-- Add Product Modal -->
    <x-modals.form wire:model.live="isAddModalOpen">
        <x-slot name="title">
            {{ __('Adicionar Produto ao Carrinho') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="produto_id" value="{{ __('Produto') }}" />
                <x-select id="produto_id" wire:model="produto_id">
                    <option value="">Escolha um produto</option>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="produto_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="quantidade" value="{{ __('Quantidade') }}" />
                <x-input id="quantidade" type="number" class="mt-1 block w-full" wire:model="quantidade" min="1" />
                <x-input-error for="quantidade" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click.prevent="closeAddModal">
                {{ __('Cancelar') }}
            </x-secondary-button>
            <x-primary-button wire:click.prevent="save" wire:loading.attr="disabled" class="ms-3">
                {{ __('Adicionar') }}
            </x-primary-button>
        </x-slot>
    </x-modals.form>

    <!-- Delete Confirmation Modal -->
    <x-confirmation-modal wire:model.live="isDeleteModalOpen">
        <x-slot name="title">
            {{ __('Excluir Produto') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja remover este produto do carrinho?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click.prevent="closeDeleteModal">
                {{ __('Cancelar') }}
            </x-secondary-button>
            <x-danger-button class="ms-3" wire:click.prevent="deleteProduto" wire:loading.attr="disabled">
                {{ __('Excluir') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Compra Confirmation Modal -->
    <x-dialog-modal wire:model.live="isComprarModalOpen">
        <x-slot name="title">
            {{ __('Efetuar Compra') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja efetuar compra do carrinho?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click.prevent="closeComprarModal">
                {{ __('Cancelar') }}
            </x-secondary-button>
            <x-primary-button class="ms-3" wire:click.prevent="compraCarrinho" wire:loading.attr="disabled">
                {{ __('Comprar') }}
            </x-primary-button>
        </x-slot>
    </x-dialog-modal>

</div>
