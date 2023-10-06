<x-app-layout>
    <h2 class="font-h1 text-3xl text-gray-800 dark:text-gray-200 leading-tight">
        Vente en cours
    </h2>
    <div class="max-w-none mx-auto gap-8 divide-y-8 space-y-4 font-paragraph">
        <!-- Display selected product -->
        <div class="flex gap-6 p-2 ml-4 mt-4 mr-2">
            <a href="#" class="bg-white shadow-xl hover:shadow flex flex-col items-center justify-between border rounded-md w-52 py-4 gap-4 transition-all duration-300">
                <!-- Product details go here -->
            </a>
        </div>
        <!-- Add more products button -->
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajouter d'autres articles
        </button>
        <!-- Finish sale button -->
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Valider la vente
        </button>
    </div>
</x-app-layout>

