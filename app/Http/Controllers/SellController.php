<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

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
            'payment_method' => 'required|array',
            'commentary' => 'nullable|string',
        ]);

        $sale = new Sale;
        $sale->article_id = $article->id;
        $sale->quantity = $validData['quantity'];
        $sale->price = $validData['price'];
        $sale->payment_method = $validData['payment_method'][0];
        $sale->commentary = $request->input('commentary');
        $sale->status = 'active';
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Vente enregistrée !');
    }

    public function updateCart(Request $request)
    {
        $articleId = $request->input('articleId');
        $newQuantity = $request->input('quantity');
        $newPrice = $request->input('price');

        $cart = Session::get('cart', []);

        if ($newQuantity == 0) {
            unset($cart[$articleId]);
        } else {
            $cart[$articleId] = [
                'quantity' => $newQuantity,
                'price' => $newPrice,
            ];
        }

        Session::put('cart', $cart);

        return Redirect::route('cart')->with('success', 'Panier mis à jour avec succès !');
    }

    public function confirmPurchase(Request $request)
    {
        $validData = $request->validate([
            'sale_id' => 'required|integer|exists:sales,id',
        ]);

        $sale = Sale::find($validData['sale_id']);
        $sale->status = 'confirmed';
        $sale->save();

        $soldArticles = Session::get('cart', []);
        foreach ($soldArticles as $articleId => $article) {
            $articleModel = Article::find($articleId);
            if ($articleModel) {
                $articleModel->quantity -= $article['quantity'];
                $articleModel->save();
            }
        }

        return redirect()->route('cart')->with('success', 'La vente a bien été enregistrée');
    }

    public function addToCart(Request $request)
{
    $selectedArticles = $request->input('selected_articles');
        $cart = Session::get('cart', []);

    foreach ($selectedArticles as $articleId) {
        $quantity = 0;
        if(isset($cart[$articleId])) {
            $quantity = $cart[$articleId]['quantity'];
        }
    }

    Session::put('cart', $cart);

    return Redirect::route('cart')->with('success', 'Article ajouté au panier avec succès !');
}
    public function cart()
{
    $cart = Session::get('cart', []);
    $selectedArticles = Article::whereIn('id', array_keys($cart))->get();
    return view('cart', compact('cart', 'selectedArticles'));
}

}
