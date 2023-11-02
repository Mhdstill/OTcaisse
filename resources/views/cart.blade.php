<x-app-layout>
    <div class="m-10 mt-12 border-8 rounded-lg border-teal-600">
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
                    @for ($i = 0; $i < count($selectedArticles); $i++)
                        <tr>
                            <td class="border px-4 py-2">{{ $selectedArticles[$i]->id ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $selectedArticles[$i]->title }}</td>
                            <td class="border px-4 py-2">
                                <form method="POST" action="{{ route('updatecart') }}">
                                    @csrf
                                    <input type="text" name="price_{{ $selectedArticles[$i]->id }}"
                                        value="{{ $selectedArticles[$i]->price }}" class="w-20 price rounded-xl border-2"
                                        data-article-id="{{ $selectedArticles[$i]->id }}"
                                        onchange="updatePrice({{ $selectedArticles[$i]->id }})"> €
                                </form>
                            </td>
                            <td class="border px-4 py-2">
                                <form method="POST" action="{{ route('updatecart') }}">
                                    @csrf
                                    <input type="number" name="quantity_{{ $selectedArticles[$i]->id }}" value="1"
                                        class="w-16 quantity rounded-xl border-2"
                                        data-article-id="{{ $selectedArticles[$i]->id }}"
                                        onchange="updateTotal({{ $selectedArticles[$i]->id }})">
                                </form>
                            </td>
                            <td class="border px-4 py-2 total_{{ $selectedArticles[$i]->id }}">
                                {{ $selectedArticles[$i]->price * $selectedArticles[$i]->quantity }} €
                            </td>
                            <td class="border px-4 py-2">
                                <form method="POST"
                                    action="{{ route('removeFromCart', ['article' => $selectedArticles[$i]->id, 'sale' => $sales[$i]->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    {{ var_dump($sales[$i]->id) }}
                                    <button type="submit"
                                        class="border-red-400 border-2 rounded-xl hover-bg-red-400 text-black font-bold py-2 px-4">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
    <div class="text-start pl-4 mt-8 mr-12 mb-8">
            <a href="{{ route('dashboard') }}"
                class="border-teal-600 border-2 rounded-xl hover-bg-teal-600 text-black font-bold py-2 px-4">
                Ajouter d'autres articles
            </a>
        </div>

    </div>

    <div name="paiement_et_total" class="text-center flex-baseline">
        <span class="text-lg font-bold">Méthode de paiement :</span>
        <div class="mt-4 ml-12 p-2">
            <label><input type="checkbox" class='rounded-xl border-2' name="payment_method[]" value="cb"> Carte
                bancaire</label>
            <label><input type="checkbox" class='rounded-xl border-2' name="payment_method[]" value="especes">
                Espèces</label>
            <label><input type="checkbox" class='rounded-xl border-2' name="payment_method[]" value="chq">
                Chèque</label>
        </div>
        <div class="border px-12 py-2">
            <span class="text-xl font-bold text-red-600">Total de la commande:</span>
            <span id="total_price" class="text-xl font-bold ml-2 text-red-600">
                {{ $selectedArticles->sum(function ($article) {return $article->price * 1;}) }} €
            </span>
        </div>
    </div>


    <div id="payment_options" style="display: none;">
        <div class="mt-4 ml-12 p-2">
            <label for="amount_cb">Montant CB :</label>
            <input type="number" name="amount_cb" id="amount_cb" class="w-24 rounded-xl border-2">
            <input type="text" name="comment_cb" id="comment_cb" placeholder="Commentaire-CB"
                class="w-48 rounded-xl border-2">
        </div>
        <div class="mt-4 ml-12 p-2">
            <label for="amount_especes">Montant espèces :</label>
            <input type="number" name="amount_especes" id="amount_especes" class="w-24 rounded-xl border-2">
            <input type="text" name="comment_especes" id="comment_especes" placeholder="Commentaire-espèces"
                class="w-48 rounded-xl border-2">
        </div>
        <div class="mt-4 ml-12 p-2">
            <label for="amount_chq">Montant chèque :</label>
            <input type="number" name="amount_chq" id="amount_chq" class="w-24 rounded-xl border-2">
            <input type="text" name="comment_chq" id="comment_chq" placeholder="Commentaire-chèque"
                class="w-48 rounded-xl border-2">
        </div>
    </div>

    <form method="POST" action="{{ route('confirmPurchase') }}">
        @csrf
        <!-- le reste du formulaire -->
        <button id="confirmPurchaseBtn" type="submit"
            class="border-teal-600 border-2 rounded-xl hover-bg-teal-600 text-black font-bold py-2 px-4">
            Valider le panier
        </button>
    </form>



    <!-- Bouton retour Caisse -->
    <div class="text-start pl-4 mt-8 mr-12">
        <a href="{{ route('dashboard') }}"
            class="border-teal-600 border-2 rounded-xl hover-bg-teal-600 text-black font-bold py-2 px-4">
            Revenir à la caisse
        </a>
    </div>

    <script>
        // Add an event listener to the checkboxes to show the payment options individually
        var checkboxes = document.querySelectorAll('input[name="payment_method[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (checkbox.value === 'cb') {
                    document.getElementById('payment_options').style.display = checkbox.checked ? 'block' :
                        'none';
                }
                if (checkbox.value === 'especes') {
                    document.getElementById('payment_options').style.display = checkbox.checked ? 'block' :
                        'none';
                }
                if (checkbox.value === 'chq') {
                    document.getElementById('payment_options').style.display = checkbox.checked ? 'block' :
                        'none';
                }
            });
        });


        function updatePrice(articleId) {
            var priceInput = document.querySelector('input[name="price_' + articleId + '"]');
            var newPrice = priceInput.value; // Get the new price entered by the user

            // Update the total of the article
            var totalElement = document.querySelector('.total_' + articleId);
            var quantity = document.querySelector('input[name="quantity_' + articleId + '"]').value;
            totalElement.textContent = quantity * newPrice + ' €';

            // Update the total sum for all articles
            var totalPriceElement = document.getElementById('total_price');
            totalPriceElement.textContent = calculateTotalSum() + ' €';
        }

        function updateTotal(articleId) {
            // Get the new quantity
            var newQuantity = document.querySelector('input[name="quantity_' + articleId + '"]').value;

            // Send an AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/updatecart', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.send('articleId=' + articleId + '&quantity=' + newQuantity);

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

        function removeFromCart(articleId) {
            var xhr = new XMLHttpRequest();
            xhr.open('DELETE', '/cart/remove/' + articleId, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.send();

            xhr.onload = function() {
                console.log('Status: ' + xhr.status);
                console.log('Response: ' + xhr.responseText);

                if (xhr.status === 200) {
                    // If the request was successful, reload the page to update the cart
                    location.reload();
                } else {
                    // If the request failed, display an error message
                    alert('Echec de la suppression de l\'article !');
                }
            };

        }

        // Confirm purchase button

        document.addEventListener("DOMContentLoaded", function() {
            var form = document.querySelector('form[action="{{ route('confirmPurchase') }}"]');
            var confirmPurchaseBtn = document.getElementById('confirmPurchaseBtn');

            confirmPurchaseBtn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default form submission
                form.submit();
            });
        });
    </script>
</x-app-layout>
