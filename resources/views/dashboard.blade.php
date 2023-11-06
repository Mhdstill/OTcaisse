<x-app-layout>
    <form method="POST" action="{{ route('addtocart') }}">
        @csrf
        <div class="max-w-none mx-auto gap-4 space-y-1 font-paragraph">
            @foreach ($categories as $category)
                <div class="flex items-center p-2 gap-2 bg-white group">
                    <div class="font-semibold text-xl" style="background-color: {{ $category->color }}">
                        {{ $category->name }}
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($category->articles as $article)
                            @if ($article->status != 'inactif')
                                <label
                                    class="shadow-sm group-hover:bg-{{ $category->color }} flex items-center justify-between p-2 transition-all duration-300">
                                    <input type="checkbox" class='rounded-xl border-2' name="selected_articles[]"
                                        value="{{ $article->id }}">
                                    <div class="">
                                        <img class="h-24 w-24 object-cover rounded-sm {{ $article->status == 'actif' ? '' : 'grayscale' }}"
                                            src="{{ $article->image != null ? url('storage/' . $article->image) : url('img/andrew-small-unsplash.jpg') }}"
                                            alt="">
                                    </div>
                                    <div class="flex flex-col gap-1 items-center justify-center text-center">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-sm">{{ $article->title }}</span>
                                        </div>
                                        <div class="text-sm -mb-1">
                                            {{ $article->price }} €
                                        </div>
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
        <div class="text-center mt-8 mflex items-center">
            <button type="submit"
                class="text-black border-4 border-emerald-300 bg-white hover:bg-emerald-300 px-3 py-1">
                Valider la sélection
            </button>
        </div>
    </form>
</x-app-layout>

