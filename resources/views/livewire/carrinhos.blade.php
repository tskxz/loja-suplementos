<div>
    <h2>Meu Carrinho</h2>

    <form wire:submit.prevent="addProduto">
        <div>
            <label for="produto_id">Produto:</label>
            <select id="produto_id" wire:model="produto_id">
                <option value="">Escolha um produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                @endforeach
            </select>
            @error('produto_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="quantidade">Quantidade:</label>
            <input id="quantidade" type="number" wire:model="quantidade" min="1">
            @error('quantidade') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Adicionar ao Carrinho</button>
    </form>

    <h3>Itens no Carrinho</h3>
    <ul>
        @foreach($itens as $item)
            <li>
                {{ $item->nome }} - Quantidade: {{ $item->pivot->quantidade }}
                <button wire:click="removeProduto({{ $item->id }})">Remover</button>
            </li>
        @endforeach
    </ul>
</div>
