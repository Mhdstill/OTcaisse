<x-app-layout>
    <div class="m-10 bg-gray-100">
        <h1 class="text-3xl mb-4 text-black">Panier</h1>
        <table class="table-auto w-full mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Article</th>
                    <th class="px-4 py-2">Prix</th>
                    <th class="px-4 py-2">Quantité</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($article)
                    <tr>
                        <td class="border px-4 py-2">{{ $article->id }}</td>
                        <td class="border px-4 py-2">{{ $article->title }}</td>
                        <td class="border px-4 py-2">
                            <input type="text" name="price" value="{{ $article->price }}" class="w-24"> €
                        </td>
                        <td class="border px-4 py-2">
                            <input type="number" name="quantity" value="1" class="w-16">
                        </td>
                        <td class="border px-4 py-2 total">
                            0.00 €
                        </td>
                        <td class="border px-4 py-2">
                            <form method="POST" action="{{ route('addtosale', ['article' => $article->id]) }}">
                                @csrf
                                <button type="submit" class="bg-teal-600 hover:bg-teal-400 text-white font-bold py-2 px-4 rounded">
                                    Ajouter au panier
                                </button>
                            </form>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        
        <!-- Button to Add Another Article -->
        <button class="bg-teal-600 hover-bg-teal-400 text-white font-bold py-2 px-4 rounded">
            Ajouter un autre article
        </button>
        
        <script>
            // JavaScript function to calculate the total
            function calculateTotal() {
                var priceInput = document.querySelector('input[name="price"]');
                var quantityInput = document.querySelector('input[name="quantity"]');
                var totalElement = document.querySelector('.total');

                var price = parseFloat(priceInput.value);
                var quantity = parseInt(quantityInput.value);

                if (!isNaN(price) && !isNaN(quantity)) {
                    var total = price * quantity;
                    totalElement.textContent = total.toFixed(2) + '€';
                } else {
                    totalElement.textContent = '0.00 €';
                }
            }

            // Add event listeners to recalculate the total when inputs change
            document.querySelector('input[name="price"]').addEventListener('input', calculateTotal);
            document.querySelector('input[name="quantity"]').addEventListener('input', calculateTotal);

            // Calculate the total initially
            calculateTotal();
        </script>
    </div>
</x-app-layout>
