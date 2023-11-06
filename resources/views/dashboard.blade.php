<x-app-layout>
    <form method="POST" action="{{ route('addtocart') }}">
        @csrf
        <div class="max-w-none mx-auto gap-4 space-y-1 font-paragraph">
            @foreach ($categories as $category)
                <div class="flex items-center p-2 gap-4" style="background-color: {{ $category->color }}">
                    <div class="font-semibold text-xl">
                        {{ $category->name }}
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($category->articles as $article)
                            @if ($article->status != 'inactif')
                                <label class="bg-white shadow-xl hover:shadow flex items-center justify-between rounded-md p-2 transition-all duration-300">
                                    <input type="checkbox" class='rounded-xl border-2' name="selected_articles[]" value="{{ $article->id }}">
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
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-8 mflex items-center">
            <button type="submit" class="font-match border-2 border-teal-600 text-black hover:bg-teal-600 rounded-xl p-2">
                Valider la sélection
            </button>
        </div>
    </form>
</x-app-layout>