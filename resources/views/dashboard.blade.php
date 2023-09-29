<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                vcxbcfx
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Article Title</th>
                            <th>Article Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            @foreach ($category->articles as $article)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->description }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
