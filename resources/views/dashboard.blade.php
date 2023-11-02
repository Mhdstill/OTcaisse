<x-app-layout>
    <div class="max-w-none mx-auto gap-4 space-y-1 font-paragraph">
        @foreach ($categories as $category)
            <div class="flex flex-col p-2 gap-4" style="background-color: {{ $category->color }}">
                <div class="font-semibold text-xl">
                    {{ $category->name }}
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($category->articles as $article)
                        @if ($article->status != 'inactif')
                            <form method="POST" class="flex flex-col gap-2"
                                action="{{ route('addtocart') }}">
                                @csrf
                                <div>
                                    <label
                                        class="shadow-xl cursor-pointer hover:shadow flex items-center justify-between rounded-md p-2 transition-all duration-300">
                                        <input type="checkbox" class='rounded-xl border-2' name="selected_articles[]"
                                            value="{{ $article->id }}">
                                        <div class="">
                                            <img class="h-24 w-24 object-cover rounded-full {{ $article->status == 'actif' ? '' : 'grayscale' }}"
                                                src="{{ $article->image != null ? url('storage/' . $article->image) : url('img/andrew-small-unsplash.jpg') }}"
                                                alt="">
                                        </div>
                                        <div class="flex flex-col gap-1 items-center justify-center text-center">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-sm">{{ $article->title }}</span>
                                            </div>
                                            <div class="text-sm -mb-1">
                                                {{ $article->price }} €
                                            </div>
                                        </div>
                                </div>
                                <div class="flex flex-col">
                                    <label for={{ 'description' . $article->id }}>
                                        Notes
                                    </label>
                                    <textarea id={{ 'description' . $article->id }} name='description' class="resize-none"></textarea>
                                </div>
                            </form>
                        @endif
                    @endforeach
                    
                </div>
            </div>
        @endforeach
        <div id="payment_options">
            <div class="mt-4 ml-12 p-2">
                <label for="amount_cb">Montant CB :</label>
                <input type="number" name="amount_cb" id="amount_cb" class="w-24 rounded-xl border-2">
                <input type="text" name="comment_cb" id="comment_cb" placeholder="Commentaire-CB"
                    class="w-48 rounded-xl border-2">
            </div>
            <div class="mt-4 ml-12 p-2">
                <label for="amount_especes">Montant espèces :</label>
                <input type="number" name="amount_especes" id="amount_especes" class="w-24 rounded-xl border-2">
                <input type="text" name="comment_especes" id="comment_especes" placeholder="Commentaire-espèces"
                    class="w-48 rounded-xl border-2">
            </div>
            <div class="mt-4 ml-12 p-2">
                <label for="amount_chq">Montant chèque :</label>
                <input type="number" name="amount_chq" id="amount_chq" class="w-24 rounded-xl border-2">
                <input type="text" name="comment_chq" id="comment_chq" placeholder="Commentaire-chèque"
                    class="w-48 rounded-xl border-2">
            </div>
        </div>
    </div>
    <div class="text-center mt-8 mflex items-center">
        <button type="submit" class="font-match border-2 border-teal-600 text-black hover:bg-teal-600 rounded-xl p-2">
            Valider la sélection
        </button>
    </div>
</x-app-layout>
