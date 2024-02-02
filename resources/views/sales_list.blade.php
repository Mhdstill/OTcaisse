<x-app-layout>
    <header class="bg-white">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between">
            <h2 class="font-h1 text-4xl font-bold text-teal-600 leading-tight">
                Ventes
            </h2>
            <button class="border-2 rounded-md border-teal-600 bg-white text-black font-h1 font-bold p-2 hover:bg-teal-600 hover:text-white mt-4 sm:mt-0" onclick="exportTableToExcel('sale_table')">
                Exporter
            </button>
        </div>
    </header>
    <div class="m-4">

        <div class="row mt-2 font-bold">
            <div class="col-lg-12 italic pb-4 text-black font-bold">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
            </div>
            <div class="relative overflow-x-auto shadow-none overflow-auto p-2">
                <table class="centered-table w-full text-sm text-left" id="sale_table">
                    <thead class="text-black sm:text-sm uppercase dark:bg-teal-600 dark:text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div>
                                    ID
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div>
                                    Article
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div>
                                    Quantité
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div>
                                    Prix
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div>
                                    Méthode de paiement
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div>
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                <div>
                                    Commentaire
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sell)
                        <tr class="px-6 py-4 dark:bg-white dark:text-black rounded-md">
                            <td scope="row" class="px-6 py-10 flex items-center dark:text-black">{{ $sell->id }}</td>
                            <td class="px-20 py-4">{{ $sell->article->title }}</td>
                            <td class="px-6 py-4 text-black whitespace-nowrap">
                                {{ $sell->quantity }}
                            </td>
                            <td class="px-20 py-4">{{ $sell->price }}€</td>
                            <td class="px-8 py-4">
                                @foreach ($sell->payments as $payment)
                                {{ $payment->method }} <br />
                                @endforeach
                            </td>
                            <td class="px-4 py-4">{{ $sell->status }}</td>
                            <td class="px-4 py-4">{{ $sell->commentary }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
    <script>
        function exportTableToExcel(tableId, filename = '') {
            /* Sélectionne le tableau HTML par son ID */
            var table = document.getElementById(tableId);
            var ws = XLSX.utils.table_to_sheet(table); // Convertit le tableau en feuille de travail

            /* Crée un nouveau classeur et y ajoute la feuille de travail */
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

            /* Génère le fichier XLSX et le télécharge */
            XLSX.writeFile(wb, filename ? filename : 'export.xlsx');
        }
    </script>


</x-app-layout>