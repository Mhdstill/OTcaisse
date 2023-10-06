<x-app-layout>

    <header class="bg-gray-600 dark:bg-teal-600 shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h2 class="font-h1 text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                Caisse
            </h2>

        </div>
    </header>


    <div class="m-8">
        <div class="row py-2">
            <div class="w-full rounded-md">
                <div class="py-2">
                    <div class="max-w-none mx-auto gap-4 space-y-4 font-paragraph">
                        @foreach ($categories as $category)
                            <div class="flex flex-col" style="background-color: {{ $category->color }}">
                                <div
                                    class="w-full ml-4 mt-4 mb-4 flex flex-col items-start rounded-md text-center text-2xl">
                                    {{ $category->name }}
                                </div>
                                <div class="flex flex-wrap gap-2 p-2 ml-4 mb-2 mr-2">
                                    @foreach ($category->articles as $article)
                                        @if ($article->status != 'inactif')
                                            <a href="#"
                                                class="{{ $article->status == 'actif' ? 'bg-white shadow-xl hover:shadow' : 'bg-gray-200' }} flex flex-col items-center justify-between border-2 rounded-md w-20 py-2 gap-2 transition-all duration-300">
                                                <img class="h-32 w-32 object-cover rounded-full {{ $article->status == 'actif' ? '' : 'grayscale' }}"
                                                    src="{{ $article->image != null ? url('storage/' . $article->image) : url('img/andrew-small-unsplash.jpg') }}"
                                                    alt="">
                                                <div
                                                    class="flex flex-col gap-2 items-center justify-center text-center">
                                                    <div class="flex flex-col">
                                                        <span class="font-semibold text-sm">{{ $article->title }}</span>
                                                    </div>
                                                    <div class="">
                                                        {{ $article->price }} €
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
