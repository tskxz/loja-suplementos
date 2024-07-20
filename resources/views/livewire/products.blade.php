<div class="p-6 sm:px-20 bg-white border-b border-gray-200">

    {{-- Header Section --}}
    <div class="mt-8 pb-4 text-2xl">
        <div>Products List</div>
    </div>

    {{-- Table Section --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left">
                            ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left">
                            Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left">
                            Price
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">

                    @foreach ($products as $product)
                        <tr>
                            <td class="px-6 py-4">
                                {{ $product->id }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ number_format($product->price, 2) }}
                            </td>
                            
                            <td class="px-6 py-4">
                                {{-- Edit Button Action --}}
                                {{-- Delete Button Action --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
        </div>
    </div>

    {{-- Footer Section --}}
    <div class="mt-4">
        {{ $products->links() }}
    </div>

    {{-- Modal Section --}}

</div>
