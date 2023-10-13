<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request; // Correct the Request import

class SellController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->get();
        return view('dashboard', compact('categories'));
    }

    public function create(Article $article)
    {
        $articles = Article::all();
        return view('cart', compact('article', 'articles'));
    }

    public function store(Request $request, Article $article)
    {
        $validData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'payment_method' => 'required|string',
            'commentary' => 'nullable|string',
        ]);

        $sale = new Sale;
        $sale->article_id = $article->id;
        $sale->quantity = $validData['quantity'];
        $sale->price = $validData['price'];
        $sale->payment_method = $validData['payment_method'];
        $sale->status = 'active';
        $sale->commentary = $validData['commentary'];

        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Vente enregistrée !'); // Fix 'succes' to 'success'
    }
}
