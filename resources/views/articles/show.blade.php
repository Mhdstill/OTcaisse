    <x-app-layout>
        <div class="m-10">
            <div class="pb-8 flex justify-around items-center">
                <h2 class="font-bold text-lg text-white">CRUD Articles - OTcaisse</h2>
                <a class="border-4 border-gray-800 bg-gray-800 text-white rounded-xl p-2"
                    href="{{ route('articles.index') }}">
                    Retour</a>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12 italic pb-4 text-white">
                    @if ($message = Session::get('success'))    
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 border-4 border-gray-800 p-4 rounded-xl bg-gray-800 text-white drop-shadow-2xl">
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
                                {{ $article->price }}
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
