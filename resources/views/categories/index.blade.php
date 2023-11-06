<x-app-layout>

    <header class="bg-white">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8 flex items-center justify-between">
            <h2 class="font-h1 text-4xl font-bold text-emerald-500 leading-tight">
                Catégories
            </h2>
            <a class="border-2 border-emerald-300 bg-white text-black font-h1 font-bold p-2 hover:bg-emerald-300 hover:text-white"
                href="{{ route('categories.create') }}">
                Créer une nouvelle catégorie</a>
        </div>
    </header>

    <div class="m-4">

        <div class="row mt-2 font-bold">
            <div class="col-lg-12 italic pb-4 text-red-700 font-bold">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>
            <div class="relative overflow-x-auto shadow-none overflow-auto p-2">
                <table class="w-full text-sm text-left">
                    <thead class="text-black sm:text-sm uppercase dark:bg-black dark:text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div class="flex items-center">
                                    Nom

                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-normal">
                                <div class="flex items-center">
                                    Couleur

                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div class="flex items-center">
                                    Description

                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3 whitespace-normal">
                                <div class="flex items-center">
                                    Statut

                                </div>
                            </th>
                            <th scope="col" class="px-12 py-3 whitespace-normal">
                                <div class="flex items-center">
                                    Action

                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="dark:bg-white dark:text-black font-bold">
                                <td class="px-6 py-4 whitespace-normal">{{ $category->name }}</td>
                                <td scope="row"
                                    class="px-2 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="h-8 w-20" style="background-color: {{ $category->color }}">

                                    </div>
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 text-black whitespace-nowrap dark:text-black">
                                    {{ $category->description }}
                                </td>
                                <td scope="row"
                                    class="px-4 py-4 text-black whitespace-nowrap dark:text-black">
                                    {{ $category->status }}
                                </td>
                                <td class="font-bold">
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a class=" text-black dark:text-black hover:underline pr-2"
                                            href="{{ route('categories.show', $category->id) }}">Voir</a>
                                            <a class=" text-green-600 dark:text-green-600 hover:underline pr-2"
                                            href="{{ route('categories.edit', $category->id) }}">Editer</a>
                                        <button type="submit"
                                            class="btn btn-danger class= text-red-600 dark:text-red-700 hover:underline">Supprimer</button>
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
