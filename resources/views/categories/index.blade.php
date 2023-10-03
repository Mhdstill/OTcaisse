<x-app-layout>

    <header class="bg-gray-600 dark:bg-teal-600 shadow">
        <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Catégories
            </h2>
            <a class="border-2 border-teal-200 bg-teal-600 text-white italic rounded-xl p-2"
                href="{{ route('categories.create') }}">
                Créer une nouvelle catégorie</a>
        </div>
    </header>

    <div class="m-10">

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
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-teal-700 dark:text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Nom

                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <div class="flex items-center">
                                    Couleur

                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Description

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
                        @foreach ($categories as $category)
                            <tr class="bg-white border-b dark:bg-teal-600 dark:border-teal-900 dark:text-white">
                                <td class="px-6 py-4">{{ $category->name }}</td>
                                <td scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="h-8 w-20" style="background-color: {{ $category->color }}">

                                    </div>
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $category->description }}
                                </td>
                                <td scope="row"
                                    class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $category->status }}
                                </td>
                                <td>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-info pr-2 class=font-medium text-lime-600 dark:text-lime-400 hover:underline"
                                            href="{{ route('categories.show', $category->id) }}">Voir</a>
                                        <a class="btn btn-primary pr-2 class=font-medium text-blue-600 dark:text-yellow-400 hover:underline"
                                            href="{{ route('categories.edit', $category->id) }}">Editer</a>
                                        <button type="submit"
                                            class="btn btn-danger class=font-medium text-red-600 dark:text-red-700 hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            </thead>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
