<?php

namespace App\Http\Controllers;


use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
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
    // You can retrieve the items in the cart and display them in the cart view.
    // Additionally, provide the option to validate and proceed with the sale.
    // Implement this as per your requirements.
}

public function checkout(Request $request)
{
    $validData = $request->validate([
        'payment_method' => 'required|string',
        'commentary' => 'nullable|string',
    ]);

    if ($validData['payment_method'] === 'multiple') {
        $validData = $request->validate([
            'other_payment_method' => 'required|string|in:credit_card,cash',
            'other_payment_amount' => 'required|numeric',
            'other_payment_comment' => 'nullable|string',
        ]);
    }

    // Process the sale based on the selected payment method
    if ($validData['payment_method'] === 'multiple') {
        // Handle the case of a partial payment with credit card and the rest by cash
        // Access the data via $validData, e.g., $validData['other_payment_method'], $validData['other_payment_amount'], $validData['other_payment_comment']
    } else {
        // Handle other payment methods (chèque, espèces, carte bancaire)
    }

    // Redirect to a success page or wherever is appropriate
    return redirect()->route('sales.index')->with('success', 'Vente enregistrée !');
}


public function removeFromCart(Article $article)
{
    $cart = Session::get('cart', []);

    // Supprimez l'article du panier
    unset($cart[$article->id]);






public function update(Request $request)
{
    // Process updates to the cart, for example, updating quantities and prices
    // You can access data from the form submission via $request

    // Example: Updating a specific article's quantity and price
    $articleId = $request->input('articleId');
    $newQuantity = $request->input('quantity');
    $newPrice = $request->input('price');

    // Perform the update logic (e.g., update the cart or database)

    // Return a response (e.g., JSON response)
    return response()->json(['message' => 'Cart updated successfully']);
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
