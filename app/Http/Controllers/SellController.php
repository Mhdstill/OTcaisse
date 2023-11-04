<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

    // public function edit ($salesId)
    // {

    // }

    public function store(Request $request)
    {
        ddd($request);
        // $validatedData = $request->validate([
        //     'quantity' => 'required|integer|min:1',
        //     'price' => 'required|numeric',
        //     'payment_method' => 'required|string|in:credit_card,cash,chq',
        //     'commentary' => 'nullable|string',
        // ]);



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


        public function removeFromCart($Request, $request)
        {
            if($request->id) {
                $cart = session()->get('cart');
               if(isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                }


                session()->flash('success', 'L\article a été retiré du panier !');

                // return back()->with('status','Quantity is Increased');
                return view('cart', compact('selectedArticles', 'totalPrice', 'sales'));

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