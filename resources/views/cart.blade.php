<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>
                <div class="bg-white rounded-lg shadow p-6">
                  @foreach ($selectedArticles as $article)
                      <div class="flex justify-between items-center border-b py-2">
                          <div class="flex items-center">
                              <img src="{{ $article->image }}" alt="{{ $article->name }}" class="w-16 h-16 mr-4">
                              <div>
                                 <h3 class="text-lg font-semibold mb-1">{{ $article->name }}</h3>
                                 <span class="text-gray-500">{{ $article->price }} €</span>
                              </div>
                          </div>
                          <div class="flex items-center">
                              <input type="number" value="{{ $article->quantity }}" class="form-input w-20 mr-4">
                              <button class="bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                          </div>
                      </div>
                  @endforeach
                </div>
            </div>
            <div class="w-full md:w-1/2 mt-6 md:mt-0 md:ml-6">
                <h2 class="text-2xl font-bold mb-4">Payment Method</h2>
                <div class="bg-white rounded-lg shadow p-6">
                  <div class="flex items-center justify-between mb-4">
                      <h3 class="text-lg font-semibold">Total</h3>
                      <span class="text-gray-500">{{ $total }} €</span>
                  </div>
                  <div class="mb-4">
                      <label class="block text-gray-700">Payment Method</label>
                      <select class="form-select w-full mt-1">
                          <option>Credit Card</option>
                          <option>Cash</option>
                          <option>Check</option>
                      </select>
                  </div>
                  <form method="POST" action="{{ route('create', ['article' => $article->id]) }}">
                      @csrf
                      <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded w-full">Checkout</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </x-app-layout>
  