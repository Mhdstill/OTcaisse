<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $article = new Article;
        $article->title = 'Offres+';
        $article->price = '10.00€';
        $article->quantity = '15';
        $article->quantity_alert = '10';
        $article->category_id = '';
        $article->image = '';
        $article->description = '';
        $article->reference = '';
        $article->status = '1';

        $article->save();

        $article = new Article;
        $article->title = 'IGN Baume les Dames';
        $article->price = '14.00€';
        $article->quantity = '12';
        $article->quantity_alert = '6';
        $article->category_id = '';
        $article->image = '';
        $article->description = 'Carte IGN Baume les Dames et la vallée du Doubs';
        $article->reference = '';
        $article->status = '';

        $article->save();
    }
}
