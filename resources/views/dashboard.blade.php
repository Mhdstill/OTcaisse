<x-app-layout>

    <div class="bg-gray-100">
        <div class="row mt-2">
            <div class="py-12">
                <div class="max-w-none mx-auto gap-8 divide-y-2">
                    @foreach ($categories as $category)
                    <div class="flex">
                        <div class="basis-1/4 flex items-center" style="background-color: {{ $category->color }}">
                            {{ $category->name }}
                        </div>
                        <div class="flex gap-4 p-4">
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
</x-app-layout>
