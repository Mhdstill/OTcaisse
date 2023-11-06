    <x-app-layout>
        <div class="m-10">
            <div class="pb-8 flex justify-start items-center">
                
                <a class="border-2 border-emerald-300 bg-white text-black hover:text-white hover:bg-emerald-300 p-2 ml-2"
                    href="{{ route('articles.index') }}">
                    Retour</a>
            </div>
            <div class="row mt-2 font-paragraph">
                <div class="col-lg-12 italic pb-4 text-red-700 font-bold">
                    @if ($message = Session::get('success'))    
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 p-4 bg-white text-black drop-shadow-2xl">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group">
                                <label class="font-bold text-lg">Titre :</label><br>
                                {{ $article->title }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group">
                                <label class="font-bold text-lg">Prix :</label><br>
                                {{ $article->price }} €
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group">
                                <label class="font-bold text-lg">Stock :</label><br>
                                {{ $article->quantity }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group">
                                <label class="font-bold text-lg">Alerte stock :</label><br>
                                {{ $article->quantity_alert }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group">
                                <label class="font-bold text-lg">Catégorie :</label><br>
                                {{ $article->category->name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group py-2">
                                <label class="font-bold text-lg" for="image">Image :</label>
                                <input type="file" name="image" id="image" class="form-control-file">
                                {{ $article->image }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group">
                                <label class="font-bold text-lg">Description :</label><br>
                                {{ $article->description }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <div class="form-group">
                                <label class="font-bold text-lg">Référence :</label><br>
                                {{ $article->reference }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
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
