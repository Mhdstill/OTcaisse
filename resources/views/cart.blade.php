<x-app-layout>
    <div class="m-10 mt-12 border-4 rounded-lg border-teal-200">
        <h1 class="text-3xl text-lobster text-black mt-4 ml-4 mb-4">Votre panier</h1>
        <form method="POST" action="{{ route('update') }}">
            @csrf
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
                                <input type="text" name="price_{{ $article->id }}" value="{{ $article->price }}"
                                    class="w-24 price" data-article-id="{{ $article->id }}" readonly> €
                            </td>
                            <td class="border px-4 py-2">
                                <input type="number" name="quantity_{{ $article->id }}" value="1"
                                    class="w-16 quantity" data-article-id="{{ $article->id }}"
                                    onchange="updateTotal({{ $article->id }})">

                            </td>
                            <td class="border px-4 py-2 total_{{ $article->id }}">
                                {{ $article->price * $article->quantity }} €
                            </td>
                            <td class="border px-4 py-2">
                                <button type="submit" name="remove" value="{{ $article->id }}"
                                    class="border-red-400 border-2 rounded-xl hover-bg-red-400 text-black font-bold py-2 px-4">
                                    Supprimer
                                </button>
                            </td>
                            <td class="border px-4 py-2 total_{{ $article->id }}">
                                {{ $article->payment_method }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
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
            <span id="total_price" class="text-xl font-bold ml-2 text-red-600">
                {{ $selectedArticles->sum(function ($article) {return $article->price * 1;}) }} €
            </span>
        </div>
    </div>

    <!-- Bouton retour Caisse -->
    <div class="text-start pl-4 mt-8 mr-12">
        <a href="{{ route('dashboard') }}"
            class="border-teal-600 border-2 rounded-xl hover-bg-teal-600 text-black font-bold py-2 px-4">
            Revenir à la caisse
        </a>
    </div>

    <script>
        function updateTotal(articleId) {
            // // Get the new quantity
            // var newQuantity = document.querySelector('input[name="quantity_' + articleId + '"]').value;

            // // Send an AJAX request to the server
            // var xhr = new XMLHttpRequest();
            // xhr.open('POST', '/updatecart', true);
            // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            // xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            // xhr.send('articleId=' + articleId + '&quantity=' + newQuantity);

            // Update the total of the article
            var totalElement = document.querySelector('.total_' + articleId);
            var price = document.querySelector('input[name="price_' + articleId + '"]').value;
            var quantity = document.querySelector('input[name="quantity_' + articleId + '"]').value;
            totalElement.textContent = quantity * price + ' €';

            // Update the total sum for all articles
            var totalPriceElement = document.getElementById('total_price');
            totalPriceElement.textContent = calculateTotalSum() + ' €';
        }

        function calculateTotalSum() {
            var totalSum = 0;
            var quantityInputs = document.querySelectorAll('.quantity');
            for (var i = 0; i < quantityInputs.length; i++) {
                var articleId = quantityInputs[i].getAttribute('data-article-id');
                var quantity = quantityInputs[i].value;
                var price = document.querySelector('input[name="price_' + articleId + '"]').value;
                totalSum += quantity * price;
            }
            return totalSum;
        }

        document.onreadystatechange = function() {
            var rows = document.querySelectorAll('table tbody tr');
            for (var i = 0; i < rows.length; i++) {
                var firstCol = rows[i].cells[0]; //first column
                updateTotal(firstCol.textContent)
            }
        }
    </script>
</x-app-layout>
