<x-app-layout>
    <div class="m-10">
        <div class="pb-8 flex justify-start items-center">
            
            <a class="border-2 border-emerald-300 bg-white text-black hover:text-white hover:bg-emerald-300 p-2 ml-2"
                href="{{ route('categories.index') }}">
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
                            <label class="font-bold text-lg">Nom :</label><br>
                            {{ $category->name }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                        <div class="form-group">
                            <label class="font-bold text-lg">Couleur :</label><br>
                          <div class="h-10 w-16" style="background-color: {{ $category->color }}"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                        <div class="form-group">
                            <label class="font-bold text-lg">Description :</label><br>
                            {{ $category->description }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                        <div class="form-group">
                            <label class="font-bold text-lg">Statut :</label><br>
                            {{ $category->status }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>
