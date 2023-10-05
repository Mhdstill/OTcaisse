<x-app-layout>
    <header class="bg-gray-600 dark:bg-teal-600 shadow">
        <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h2 class="font-h1 text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                Articles
            </h2>
            <a class="border-2 border-teal-200 bg-teal-600 text-white font-h1 rounded-xl p-2"
                href="{{ route('articles.create') }}">
                Créer un nouvel article</a>
        </div>
    </header>
    <div class="m-10">

        <div class="row mt-2 font-paragraph">
            <div class="col-lg-12 italic pb-4 text-white">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-teal-700 dark:text-white">
                        <tr>
                            <th scope="col" class="px-4 py-3">
                                <div class="flex items-center">
                                    Image
                                </div>
                            </th>
                            <th scope="col" class="px-12 py-3">
                                <div class="flex items-center">
                                    Titre
                                </div>
                            </th>
                            <th scope="col" class="px-8 py-3">
                                <div class="flex items-center">
                                    Prix
                                </div>
                            </th>
                            <th scope="col" class="px-16 py-3">
                                <div class="flex items-center">
                                    Stock
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Alerte stock
                                </div>
                            </th>
                            <th scope="col" class="px-10 py-3">
                                <div class="flex items-center">
                                    Catégorie
                                </div>
                            </th>

                            <th scope="col" class="px-12 py-3">
                                <div class="flex items-center">
                                    Description
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Référence
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="flex items-center">
                                    Statut
                                </div>
                            </th>
                            <th scope="col" class="px-12 py-3">
                                <div class="flex items-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr class="bg-white border-b dark:bg-teal-600 dark:border-teal-900 dark:text-white">
                                <td class="px-4 py-0.5">
                                    <img class="h-24 w-26 object-cover rounded-full {{ $article->status == 'actif' ? '' : 'grayscale' }}"
                                        src="{{ $article->image != null ? url('storage/' . $article->image) : url('img/andrew-small-unsplash.jpg') }}"
                                        alt="">
                                </td>
                                <td scope="row" class="px-2 py-4 dark:text-white">{{ $article->title }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $article->price }} €</td>
                                <td class="px-20 py-4">{{ $article->quantity }}</td>
                                <td class="px-8 py-4">{{ $article->quantity_alert }}</td>
                                <td class="px-12 py-4">
                                    {{ $article->category != null ? $article->category->name : 'ND' }}</td>
                                <td class="px-8 py-4">{{ $article->description }}</td>
                                <td class="px-4 py-4">{{ $article->reference }}</td>
                                <td class="px-4 py-4">{{ $article->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('articles.destroy', $article) }}" method="POST">

                                        <a class="font-medium text-lime-500 dark:text-lime-400 hover:underline pr-2"
                                            href="{{ route('articles.show', $article) }}">Voir</a>

                                        <a class="font-medium text-blue-600 dark:text-yellow-400 hover:underline pr-2"
                                            href="{{ route('articles.edit', $article) }}">Editer</a>

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="font-medium text-red-600 dark:text-red-700 hover:underline">Supprimer</button>
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
