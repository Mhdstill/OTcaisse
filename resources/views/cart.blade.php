<x-app-layout>
    <div class="m-10 mt-12 border-4 rounded-lg border-teal-200">
        <h1 class="text-3xl text-lobster text-black mt-4 ml-4 mb-4">Votre panier</h1>
        <table class="table-auto w-full mb-6">
            <thead>
                <tr class="px-4 py-3 border-gray-400">
                    <th>ID</th>
                    <th>Article</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($selectedArticles as $article)
                    <tr>
                        <td class="border px-4 py-2">{{ $article->id }}</td>
                        <td class="border px-4 py-2">{{ $article->title }}</td>
                        <td class="border px-4 py-2">
                            <input type="text" id="price_{{ $article->id }}" value="{{ $article->price }}"
                                class="w-24 price" data-article-id="{{ $article->id }}"> €
                        </td>
                        <td class="border px-4 py-2">
                            <input type="number" id="quantity_{{ $article->id }}" value="1" class="w-16 quantity"
                                data-article-id="{{ $article->id }}">
                        </td>
                        <td class="border px-4 py-2 total_{{ $article->id }}">
                            {{ $article->price }} €
                        </td>
                        <td class="border px-4 py-2">
                            <form method="POST" action="{{ route('removefromcart', ['article' => $article->id]) }}">
                                @csrf
                                @method('DELETE') <!-- Include the DELETE method for the form -->
                                <button type="submit"
                                    class="border-red-400 border-2 rounded-xl hover:bg-red-400 text-black font-bold py-2 px-4">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                        <td class="border px-4 py-2 total_{{ $article->id }}">
                            {{ $article->payment_method }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div name="paiement_et_total" class="text-center flex-baseline">
        <span class="text-lg font-bold">Méthode de paiement :</span>
        <div class="mt-4 ml-12 p-2">
            <label><input type="radio" name="payment_method" value="chq" checked> Chèque</label>
            <label><input type="radio" name="payment_method" value="especes"> Espèces</label>
            <label><input type="radio" name="payment_method" value="cb"> Carte bancaire</label>
        </div>
        <div class="border px-12 py-2">
            <span class="text-xl font-bold text-red-600">Total de la commande:</span>
            <span id="total_price" class="text-xl font-bold ml-2 text-red-600">0 €</span>
        </div>
    </div>



    <!-- Bouton retour Caisse -->
    <div class="text-start pl-4 mt-8 mr-12">
        <a href="{{ route('dashboard') }}"
            class="border-teal-600 border-2 rounded-xl hover:bg-teal-600 text-black font-bold py-2 px-4">
            Revenir à la caisse
        </a>
    </div>

    <script>
        // Javascript code for my cart
        @foreach ($selectedArticles as $article)
            (function() {
                // Get the price input, quantity input, and total element for this article
                let priceInput = document.getElementById(`price_{{ $article->id }}`);
                let quantityInput = document.getElementById(`quantity_{{ $article->id }}`);
                let totalElement = document.querySelector(`.total_{{ $article->id }}`);

                // Function to calculate and update the total for this article
                function calculateArticleTotal() {
                    let price = parseFloat(priceInput.value);
                    let quantity = parseInt(quantityInput.value);
                    if (!isNaN(price) && !isNaN(quantity)) {
                        let total = price * quantity;
                        totalElement.textContent = total.toFixed(2) + ' €';
                    }
                }

                // Add event listeners to the price and quantity inputs
                priceInput.addEventListener('input', calculateArticleTotal);
                quantityInput.addEventListener('input', calculateArticleTotal);

                // Calculate the initial total for this article
                calculateArticleTotal();
            })();
        @endforeach
    </script>


    </div>
</x-app-layout>
