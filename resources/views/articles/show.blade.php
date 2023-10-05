    <x-app-layout>
        <div class="m-10 bg-gray-100">
            <div class="pb-8 flex justify-start items-center">
                <a class="border-4 border-teal-400 bg-white text-black font-paragraph rounded-xl p-2 ml-2"
                    href="{{ route('articles.index') }}">
                    Retour</a>
            </div>
            <div class="row mt-2 font-paragraph">
                <div class="col-lg-12 italic pb-4 text-white">
                    @if ($message = Session::get('success'))    
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 border-4 border-teal-400 p-4 rounded-xl bg-teal-800 text-white drop-shadow-2xl">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group  border-b">
                                <label class="font-bold text-lg">Titre :</label><br>
                                {{ $article->title }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5 border-b">
                            <div class="form-group">
                                <label class="font-bold text-lg">Prix :</label><br>
                                {{ $article->price }} €
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5 border-b">
                            <div class="form-group">
                                <label class="font-bold text-lg">Stock :</label><br>
                                {{ $article->quantity }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5 border-b">
                            <div class="form-group">
                                <label class="font-bold text-lg">Alerte stock :</label><br>
                                {{ $article->quantity_alert }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5 border-b">
                            <div class="form-group">
                                <label class="font-bold text-lg">Catégorie :</label><br>
                                {{ $article->category->name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5 border-b">
                            <div class="form-group py-2">
                                <label class="font-bold text-lg" for="image">Image :</label>
                                <input type="file" name="image" id="image" class="form-control-file">
                                {{ $article->image }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5 border-b">
                            <div class="form-group">
                                <label class="font-bold text-lg">Description :</label><br>
                                {{ $article->description }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5 border-b">
                            <div class="form-group">
                                <label class="font-bold text-lg">Référence :</label><br>
                                {{ $article->reference }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5 border-b">
                            <div class="form-group">
                                <label class="font-bold text-lg">Statut :</label><br>
                                {{ $article->status }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
