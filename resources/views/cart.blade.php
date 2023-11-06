<x-app-layout>
    <div class="m-10 mt-12 border-2 border-red-200 shadow-md shadow-red-300">
        <h1 class="text-3xl text-lobster text-black mt-4 ml-4 mb-6">Mon panier</h1>
        <form method="POST" action="{{ route('updatecart') }}">
            @csrf
            <table class="table-auto w-full mb-6">
                <thead>
                    <tr class="px-4 py-3">
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
                        <tr class="text-center">
                            <td>{{ $article->id ?? 'N/A' }}</td>
                            <td >{{ $article->title }}</td>
                            <td>
                                <input type="text" name="price_{{ $article->id }}" value="{{ $article->price }}"
                                    class="w-20 price" data-article-id="{{ $article->id }}"
                                    onchange="updatePrice({{ $article->id }})"> €
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="quantity_{{ $article->id }}" value="1"
                                    class="w-16 quantity" data-article-id="{{ $article->id }}"
                                    onchange="updateTotal({{ $article->id }})">
                            </td>
                            <td class="px-4 py-2 total_{{ $article->id }}">
                                {{ $article->price * $article->quantity }} €
                            </td>
                            <td class="px-2 py-2 flex justify-center items-center">
                                <form method="POST" action="{{ route('updatecart') }}">
                                    @csrf
                                    <input type="hidden" name="articleId" value="{{ $article->id }}">
                                    <input type="hidden" name="quantity" value="0">
                                    <button type="submit"
                                        class="border-red-400 text-center hover:text-white hover:bg-red-600 text-red-600 font-bold py-2 px-4">
                                        X
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


    </div>


    <div name="options" class="flex justify-center items-center">

        <a href="{{ route('dashboard') }}"
            class="border-emerald-300 border-2 hover:bg-emerald-300 text-black font-bold py-2 px-4">
            Ajouter d'autres articles
        </a>

        <form method="POST" action="{{ route('confirmPurchase') }}" class="ml-10">
            @csrf
            <button id="confirmPurchaseBtn" type="submit"
                class="border-emerald-300 border-2 hover:bg-emerald-300 text-black font-bold py-2 px-4">
                Valider le panier
            </button>
        </form>
    </div>


    <div name="moneycomestomama" class="flex flex-col items-center">
        <div name="grandtotal">
            <div class="px-12 py-4">
                <span class="text-xl font-bold text-red-600">Total de la commande:</span>
                <span id="total_price" class="text-xl font-bold ml-2 text-red-600">
                    {{ $selectedArticles->sum(function ($article) {return $article->price * 1;}) }} €
                </span>
            </div>

        </div>


        <div name="moyenspaiement"></div>
        <span class="text-lg font-bold">Méthode de paiement :</span>
        <div class="mt-4 ml-12 p-2">
            <label><input type="checkbox" class='border-2' name="payment_method[]" value="cb"> Carte
                bancaire</label>
            <label><input type="checkbox" class='border-2' name="payment_method[]" value="especes">
                Espèces</label>
            <label><input type="checkbox" class='border-2' name="payment_method[]" value="chq">
                Chèque</label>
        </div>
        <div id="payment_options" class="flex justify-center items-center" style="display: none;">
            <div class="mt-4 ml-12 p-4">
                <label for="amount_cb">Montant CB :</label>
                <input type="number" name="amount_cb" id="amount_cb" class="w-24 border-2">
                <input type="text" name="comment_cb" id="comment_cb" placeholder="Commentaire-CB"
                    class="w-48 border-2">
            </div>
            <div class="mt-4 ml-12 p-4">
                <label for="amount_especes">Montant espèces :</label>
                <input type="number" name="amount_especes" id="amount_especes" class="w-24 border-2">
                <input type="text" name="comment_especes" id="comment_especes" placeholder="Commentaire-espèces"
                    class="w-48 border-2">
            </div>
            <div class="mt-4 ml-12 p-2">
                <label for="amount_chq">Montant chèque :</label>
                <input type="number" name="amount_chq" id="amount_chq" class="w-24 border-2">
                <input type="text" name="comment_chq" id="comment_chq" placeholder="Commentaire-chèque"
                    class="w-48 border-2">
            </div>
        </div>
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
