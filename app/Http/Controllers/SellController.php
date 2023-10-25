<?php

namespace App\Http\Controllers;


use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
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
            'payment_method' => 'required|array',
            'commentary' => 'nullable|string',
        ]);
    
        $sale = new Sale;
        $sale->article_id = $article->id;
        $sale->quantity = $validData['quantity'];
        $sale->price = $validData['price'];
    
        if (in_array('multiple', $validData['payment_method'])) {
            $validData = $request->validate([
                'other_payment_method' => 'required|string|in:credit_card,cash,chq',
                'other_payment_amount' => 'required|numeric',
                'other_payment_comment' => 'nullable|string',
            ]);
            $sale->payment_method = $validData['other_payment_method'];
    
            // Determine the specific commentary field based on the selected payment method
            if ($validData['other_payment_method'] === 'credit_card') {
                $sale->commentary = $validData['other_payment_comment'];
            } elseif ($validData['other_payment_method'] === 'cash') {
                $sale->commentary = $validData['other_payment_comment'];
            } elseif ($validData['other_payment_method'] === 'chq') {
                $sale->commentary = $validData['other_payment_comment'];
            }
        } else {
            $sale->payment_method = $validData['payment_method'][0];
            $sale->commentary = $request->input('commentary');
        }
    
        $sale->status = 'active';
        $sale->save();
    
        return redirect()->route('sales.index')->with('success', 'Vente enregistrée !');
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
    $cart = Session::get('cart', []);
    $selectedArticles = collect($cart)->map(function ($item, $id) {
        return Article::find($id);
    });
    return view('cart', compact('selectedArticles'));
}





public function removeFromCart(Article $article)
{
    $cart = Session::get('cart', []);

    if (array_key_exists($article->id, $cart)) {
        unset($cart[$article->id]);
        Session::put('cart', $cart);
        // Add debugging statements to check cart data
        dd($cart); // This will show the updated cart data
        return redirect()->route('cart')->with('success', 'Article supprimé du panier avec succès !');
    } else {
        return redirect()->route('cart')->with('error', 'L\'article n\'existe pas dans le panier.');
    }
}


public function update(Request $request)
{
    // Process updates to the cart, for example, updating quantities and prices
    // You can access data from the form submission via $request

    // Example: Updating a specific article's quantity and price
    $articleId = $request->input('articleId');
    $newQuantity = $request->input('quantity');
    $newPrice = $request->input('price');

    $cart = Session::get('cart', []);

    // Si la quantité est zéro, supprimez l'article du panier
    if ($newQuantity == 0) {
        unset($cart[$articleId]);
    } else {
        // Sinon, mettez à jour l'article dans le panier
        $cart[$articleId] = [
            'quantity' => $newQuantity,
            'price' => $newPrice,
        ];
    }

    // Enregistrez le panier mis à jour dans la session
    Session::put('cart', $cart);

    return Redirect::route('cart')->with('success', 'Panier mis à jour avec succès !');
}


public function confirmPurchase(Request $request)
{
    // Validate the request
    $validData = $request->validate([
        'sale_id' => 'required|integer|exists:sales,id',
    ]);

    // Find the sale
    $sale = Sale::find($validData['sale_id']);

    // Confirm the purchase
    $sale->status = 'confirmed';
    $sale->save();

    // Redirect to a success page or wherever is appropriate
    return redirect()->route('sales.index')->with('success', 'Vente confirmée!');
}


}
