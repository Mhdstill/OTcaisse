<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl font-bold mb-4">Confirm Purchase</h2>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Total</h3>
                        <span class="text-gray-500">{{ $total }} €</span>
                    </div>
                    <form method="POST" action="{{ route('store') }}">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded w-full">Finalize Purchase</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
