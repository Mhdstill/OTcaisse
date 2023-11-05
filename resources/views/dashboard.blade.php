<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
                <div class="bg-white rounded-lg shadow p-6">
                    @foreach ($categories as $category)
                        <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
                        @foreach ($category->articles as $article)
                            <div class="flex justify-between items-center border-b py-2">
                                <div class="flex items-center">
                                    <img src="{{ $article->image != null ? url('storage/' . $article->image) : url('img/andrew-small-unsplash.jpg') }}"
                                        alt="{{ $article->name }}" class="w-16 h-16 mr-4">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-1">{{ $article->name }}</h3>
                                        <span class="text-gray-500">{{ $article->price }} €</span>
                                    </div>
                                </div>
                                <!-- "Add to Cart" button -->
                                <div class="flex items-center">
                                    <form method="POST" action="{{ route('add', ['article' => $article->id]) }}">
                                        @csrf
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="w-12 mr-2">
                                        <button type="submit"
                                            class="text-black border-2 border-emerald-300 bg-white hover:bg-emerald-300 px-3 py-1">Add
                                            to Cart</button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div id="cart" class="w-full md:w-1/2 mt-6 md:mt-0 md:ml-6" style="display: none;">
                <h2 class="text-2xl font-bold mb-4">Cart</h2>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Total</h3>
                        <span class="text-gray-500">{{ $total }} €</span>
                    </div>
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Moyen de paiement</label>
                        <div id="paymentMethods">
                            <div class="flex items-center mb-2">
                                <select class="form-select w-1/2 mr-4" name="payment_methods[0][method]">
                                    <option>Credit Card</option>
                                    <option>Cash</option>
                                    <option>Check</option>
                                </select>
                                <input type="number" class="form-input w-1/2" name="payment_methods[0][amount]"
                                    value="{{ $total }}">
                            </div>
                        </div>
                        <button type="button" id="addPaymentMethod"
                            class="bg-teal-600 text-white px-3 py-1 rounded">Add Payment Method</button>
                    </div>
                    <form method="POST" action="{{ route('confirm') }}">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded w-full">Confirm
                            Purchase</button>
                    </form>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addPaymentMethod').addEventListener('click', function() {
            var paymentMethods = document.getElementById('paymentMethods');
            var index = paymentMethods.children.length;
            var div = document.createElement('div');
            div.className = 'flex items-center mb-2';
            div.innerHTML = '<select class="form-select w-1/2 mr-4" name="payment_methods[' + index +
                '][method]"><option>Credit Card</option><option>Cash</option><option>Check</option></select><input type="number" class="form-input w-1/2" name="payment_methods[' +
                index + '][amount]" value="{{ $total }}">';
            paymentMethods.appendChild(div);
        });

        function showCart(event) {
            event.preventDefault();
            document.getElementById('cart').style.display = 'block';
        }
    </script>




</x-app-layout>
