<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

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
        $sale = new Sale;
        return view('cart', compact('article', 'articles', 'sale'));
    }

    public function store(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'payment_method' => 'required|string|in:credit_card,cash,chq',
            'commentary' => 'nullable|string',
        ]);

        $sale = new Sale;
        $sale->article_id = $article->id;
        $sale->quantity = $validatedData['quantity'];
        $sale->price = $validatedData['price'];
        $sale->payment_method = $validatedData['payment_method'];
        $sale->commentary = $validatedData['commentary'];
        $sale->status = 'active';
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Sale recorded!');
    }

    public function addToCart(Request $request)
    {
        $selectedArticleIds = $request->input('selected_articles');
        $selectedArticles = Article::whereIn('id', $selectedArticleIds)->get();

        $sales = [];

        // Create a new sale for each article
        foreach ($selectedArticles as $selectedArticle) {
            $sale = new Sale;
            $sale->article_id = $selectedArticle->id;
            $sale->quantity = 1;
            $sale->price = $selectedArticle->price;
            $sale->payment_method = 'carte_bancaire'; // Correct
            $sale->status = 'actif';
            $sale->save();

            $sales[] = $sale;
        }

        $totalPrice = $selectedArticles->sum('price');

        return view('cart', compact('selectedArticles', 'totalPrice', 'sales'));
    }

    public function checkout(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string|in:credit_card,cash',
            'commentary' => 'nullable|string',
        ]);

        if ($validatedData['payment_method'] === 'credit_card') {
            // Handle credit card payment
        } elseif ($validatedData['payment_method'] === 'cash') {
            // Handle cash payment
        }

        return redirect()->route('sales.index')->with('success', 'Sale recorded!');
    }

    public function removeFromCart($articleId, $saleId)
    {
        // Remove the sale from the cart
        $cart = Session::get('cart', []);
        if (array_key_exists($articleId, $cart)) {
            unset($cart[$articleId]);
            Session::put('cart', $cart);
    
            // Delete the corresponding sale
            Sale::where('id', $saleId)->delete();
    
            return redirect()->route('removeFromCart', ['article' => $articleId, 'sale' => $saleId])->with('success', 'L\'Article a bien été retiré du panier!');

        } else {
            return redirect()->route('removeFromCart', ['article' => $articleId, 'sale' => $saleId])->with('error', 'The article does not exist in the cart.');

        }
    }
    


    public function updateCart(Request $request)
    {
        // Process updates to the cart, for example, updating quantities and prices
        // You can access data from the form submission via $request

        // Example: Updating a specific article's quantity and price
        $articleId = $request->input('articleId');
        $newQuantity = $request->input('quantity');
        $newPrice = $request->input('price');

        $cart = Session::get('cart', []);

        // If the quantity is zero, remove the article from the cart
        if ($newQuantity == 0) {
            unset($cart[$articleId]);
        } else {
            // Otherwise, update the article in the cart
            $cart[$articleId] = [
                'quantity' => $newQuantity,
                'price' => $newPrice,
            ];
        }

        // Save the updated cart in the session
        Session::put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Cart updated successfully!');
    }

    public function confirmPurchase(Request $request)
    {
        $validatedData = $request->validate([
            'sale_id' => 'required|integer|exists:sales,id',
        ]);

        // Find the sale
        $sale = Sale::find($validatedData['sale_id']);

        // Confirm the purchase
        $sale->status = 'confirmed';
        $sale->save();

        // Update the quantity of the sold articles
        $soldArticles = Session::get('cart', []);
        foreach ($soldArticles as $articleId => $article) {
            $articleModel = Article::find($articleId);
            if ($articleModel) {
                $articleModel->quantity -= $article['quantity'];
                $articleModel->save();
            }
        }

        return redirect()->route('cart')->with('success', 'Sale recorded successfully');
    }
}
