<x-app-layout>

    <header class="bg-gray-600 dark:bg-teal-600 shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h2 class="font-h1 text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                Caisse
            </h2>

        </div>
    </header>


    <div class="px-4">
        <div class="row py-2">
            <div class="w-full rounded-md">
                <div class="py-2">
                    <div class="max-w-none mx-auto gap-4 space-y-1 font-paragraph">
                        @foreach ($categories as $category)
                            <div class="flex items-center p-2 gap-4" style="background-color: {{ $category->color }}">
                                <div
                                    class="font-semibold text-xl">
                                    {{ $category->name }}
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($category->articles as $article)
                                        @if ($article->status != 'inactif')
                                            <a href="{{ url('/nouvelle-vente') }}" class="bg-white shadow-xl hover:shadow flex items-center justify-between border-2 rounded-md p-2 gap-2 transition-all duration-300">
                                                {{-- <div class="">
                                                    <img class="h-24 w-24 object-cover rounded-full {{ $article->status == 'actif' ? '' : 'grayscale' }}"
                                                    src="{{ $article->image != null ? url('storage/' . $article->image) : url('img/andrew-small-unsplash.jpg') }}"
                                                    alt="">
                                                </div> --}}
                                                <div class="flex flex-col gap-1 items-center justify-center text-center">
                                                    <div class="flex flex-col">
                                                        <span class="font-semibold text-sm">{{ $article->title }}</span>
                                                    </div>
                                                    <div class="text-sm -mb-1">
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
