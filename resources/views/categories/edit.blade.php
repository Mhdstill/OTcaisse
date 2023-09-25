<x-app-layout>
    <div class="m-10">
        <div class="pb-8 flex justify-around items-center">
            <h2 class="font-bold text-lg text-white">CRUD Categories - OTcaisse</h2>
            <a class="border-4 border-gray-800 bg-gray-800 text-white rounded-xl p-2" href="{{ route('categories.index') }}">
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        Il y a un problème avec votre enregistrement.<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                              <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <label class="font-bold text-lg">Nom:</label>
                            <div class="form-group text-black">
                                <input type="text" name="name" class="form-control w-full" placeholder="Nom">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <label class="font-bold text-lg">Couleur:</label>
                            <div class="form-group text-black">
                                <input type="text" name="color" class="form-control w-full" placeholder="Couleur">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <label class="font-bold text-lg">Description:</label>
                            <div class="form-group text-black">
                                <input type="text" name="description" class="form-control w-full" placeholder="Description">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pb-5">
                            <label class="font-bold text-lg">Statut:</label>
                            <div class="form-group text-black">
                                <input type="text" name="status" class="form-control w-full" placeholder="Statut">
                            </div>
                        </div>
                               <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="border-4 border-gray-800 bg-white  text-gray-800 rounded-xl p-2">Envoyer</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>
