<x-app-layout>
    <header class="bg-gray-600 dark:bg-teal-600 shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h2 class="font-h1 text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                Caisse
            </h2>
            
        </div>
    </header>
    <div class="m-10 bg-gradient-to-r from-teal-300 to-teal-500">
    <div class="row py-2">
        <div class="w-full rounded-md">
        
            <div class="py-2">
                <div class="max-w-none mx-auto gap-8 divide-y-8 space-y-4 font-paragraph">
                    @foreach ($categories as $category)
                    <div class="flex">
                        <div class="basis-1/4  ml-4 mt-4 mr-2 flex flex-col items-center justify-center rounded-md text-center text-2xl" style="background-color: {{ $category->color }}">
                            {{ $category->name }}
                        </div>
                        <div class="flex gap-6 p-2 ml-4 mt-4 mr-2">
                            @foreach ($category->articles as $article)
                            <a href="#" class="{{ $article->status == 'actif' ? 'bg-white shadow-xl hover:shadow' : 'bg-gray-200' }} flex flex-col items-center justify-between border rounded-md w-52 py-4 gap-4 transition-all duration-300">
                                <img class="h-24 w-24 object-cover rounded-full {{ $article->status == 'actif' ? '' : 'grayscale' }}" src="{{ $article->image != null ? url('storage/'.$article->image) : url('img/andrew-small-unsplash.jpg') }}" alt="">
                                <div class="flex flex-col gap-2 items-center justify-center text-center">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-md">{{ $article->title }}</span>
                                        @if($article->status != 'actif')
                                        <span class="bg-orange-600 text-white py-0.5 px-2 rounded-md">inactif</span>
                                        @endif
                                    </div>
                                    <div class="">
                                        {{ $article->price }} €
                                    </div>
                                    <div class="">
                                        <span class="bg-blue-400 text-white py-0.5 px-2 rounded-md">stock : {{ $article->quantity }}</span>
                                    </div>
                                    <div class="-mt-2 flex flex-col w-full">
                                        @if($article->quantity < $article->quantity_alert)
                                            <span class="bg-red-600 text-white py-0.5 px-2 rounded-md">bientôt épuisé !</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
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
