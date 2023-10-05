<x-app-layout>
    <!-- Include the header section from your existing dashboard layout -->
    <x-slot name="header">
        <header class="bg-gray-600 dark:bg-teal-600 shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <h2 class="font-h1 text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                    Ventes
                </h2>
                
            </div>
        </header>
    </x-slot>

    <!-- Include any other common elements from your dashboard layout here -->

    <div class="py-10 px-4">
        <div class="max-w-3xl mx-auto">
            <h3 class="text-2xl font-semibold mb-4">Vente d'article : {{ $article->title }}</h3>
            
            <!-- The rest of your sales management content goes here -->

            <!-- For example, the form for adding sales, sales list, and total amount -->

        </div>
    </div>
</x-app-layout>
