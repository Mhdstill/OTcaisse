<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category;
        $category->name = 'Petite Carte postale Claire D.';
        $category->color = 'bleu';
        $category->description = 'Cette petite carte postale de Claire D. représente une jolie vache dans le Doubs.';
        $category->status = '1';

        $category->save();

        $category = new Category;
        $category->name = 'Topo escalade Clémont';
        $category->color = 'jaune';
        $category->description = 'Le topo escalade Clément :lire détails.';
        $category->status = '1';

        $category->save();

        $category = new Category;
        $category->name = 'Autres';
        $category->color = 'gris';
        $category->description = 'Catégorie Autres pour les inclassables: offres diverses.';
        $category->status = '1';

        $category->save();
    }
}
