<x-app-layout>
    <header class="bg-gray-600 dark:bg-teal-600 shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h2 class="font-h1 text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                Shopping Cart
            </h2>
        </div>
    </header>

    <div class="container mx-auto mt-6 p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($cart as $item)
                <div class="border p-4 rounded shadow-lg">
                    <h2 class="text-xl font-semibold">{{ $item['article']->title }}</h2>
                    <p>Price: {{ $item['article']->price }} €</p>
                    <p>Quantity: {{ $item['quantity'] }}</p>
                    <p>Total: {{ $item['quantity'] * $item['article']->price }} €</p>
                    <a href="{{ route('cart.remove', ['id' => $item['article']->id]) }}" class="text-red-500">Remove</a>
                </div>
            @endforeach
        </div>
        <div class="mt-4 text-xl font-semibold">
            Total: {{ $totalPrice }} €
        </div>
        <div class="mt-4">
            <a href="{{ route('checkout.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Checkout</a>
        </div>
    </div>
</x-app-layout>
