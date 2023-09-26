<x-app-layout>

    <div class="m-10">
        <div class="pb-8 flex justify-around items-center">
            <h2 class="font-bold text-lg text-white">CRUD Articles - OTcaisse</h2>
            <a class="border-4 border-gray-800 bg-gray-800 text-white rounded-xl p-2"
                href="{{ route('articles.create') }}">
                Ajouter un article</a>
            <a class="border-4 border-gray-800 bg-gray-800 text-white rounded-xl p-2" href="{{ route('dashboard') }}">
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
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Titre
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Prix
                                </div>
                            </th>
                            <th scope="col" class="px-16 py-3">
                                <div class="flex items-center">
                                    Stock
                                </div>
                            </th>
                            <th scope="col" class="px-16 py-3">
                                <div class="flex items-center">
                                    Alerte stock
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Catégorie
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Image
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Description
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Référence
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Statut
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Action
                                </div>
                            </th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row" class="px-6 py-4">{{ $article->title }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $article->price }} €</td>
                                <td class="px-16 py-4">{{ $article->quantity }}</td>
                                <td class="px-16 py-4">{{ $article->quantity_alert }}</td>
                                <td class="px-16 py-4">{{ $article->category != null ? $article->category->name : 'ND' }}</td>
                                <td class="px-16 py-4">{{ $article->image }}</td>
                                <td class="px-16 py-4">{{ $article->description }}</td>
                                <td class="px-16 py-4">{{ $article->reference }}</td>
                                <td class="px-16 py-4">{{ $article->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('articles.destroy', $article) }}" method="POST">

                                        <a class="font-medium text-green-600 dark:text-green-500 hover:underline pr-2"
                                            href="{{ route('articles.show', $article) }}">Voir</a>

                                        <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline pr-2"
                                            href="{{ route('articles.edit', $article) }}">Editer</a>

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
