<?php

namespace App\Http\Controllers;


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

    public function addToCart(Request $request)
{
    // Retrieve the selected articles
    $selectedArticleIds = $request->input('selected_articles');
    
    if ($selectedArticleIds) { // Check if $selectedArticleIds is not null
        $selectedArticles = Article::whereIn('id', $selectedArticleIds)->get();
    } else {
        $selectedArticles = []; // Initialize an empty array if no articles are selected
    }

    // You can calculate the total price of selected articles here
    $totalPrice = $selectedArticles->sum('price');

    // Pass the selected articles and total price to the cart view
    return view('cart', compact('selectedArticles', 'totalPrice'));
}


public function cart()
{
    // You can retrieve the items in the cart and display them in the cart view.
    // Additionally, provide the option to validate and proceed with the sale.
    // Implement this as per your requirements.
}

public function checkout(Request $request)
{
    // Validate and process the sale, e.g., create sale records in the database
    // You can access the selected articles from the session or as request data

    // Redirect to a success page or wherever is appropriate
    return redirect()->route('sales.index')->with('success', 'Vente enregistrée !');
}

public function removeFromCart(Article $article)
{
    // Supprimez l'article du panier, en fonction de votre logique d'application.
    // Par exemple, si vous stockez les articles du panier en session, vous pouvez le supprimer de la session ici.

    // Redirigez ensuite l'utilisateur vers la vue du panier mise à jour.
    return redirect()->route('cart')->with('success', 'Article supprimé du panier !');
}


}
