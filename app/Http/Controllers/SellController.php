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
        $selectedArticleIds = $request->input('selected_articles');

        if ($selectedArticleIds) {
            $selectedArticles = Article::whereIn('id', $selectedArticleIds)->get();
        } else {
            $selectedArticles = collect();
        }

        $totalPrice = $selectedArticles->sum('price');

        return view('cart', compact('selectedArticles', 'totalPrice'));
    }


    public function cart()
    {
        $cart = Session::get('cart', []);
        $selectedArticles = collect($cart)->map(function ($item, $id) use ($cart) {
            $article = Article::find($id);
            if (!$article) {
                unset($cart[$id]);
                Session::put('cart', $cart);
            }
            return $article;
        });
    
        return view('cart', compact('selectedArticles'));
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


    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);
        if (array_key_exists($id, $cart)) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            return redirect()->route('cart')->with('success', 'Article supprimé du panier avec succès !');
        } else {
            return redirect()->route('cart')->with('error', 'L\'article n\'existe pas dans le panier.');
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

    // Update the quantity of the sold articles
    $soldArticles = Session::get('cart', []);
    foreach ($soldArticles as $articleId => $article) {
        $articleModel = Article::find($articleId);
        if ($articleModel) {
            $articleModel->quantity -= $article['quantity'];
            $articleModel->save();
        }
    }

    // Redirect to the cart page and flash a success message
    return redirect()->route('cart')->with('success', 'La vente a bien été enregistrée');
}

public function statistics()
{
    // Get the total number of sales per day
    $totalSalesPerDay = Sale::selectRaw('date(created_at) as date, count(*) as count')
        ->groupBy('date')
        ->get();

    // Get the total number of sales per article
    $totalSalesPerArticle = Sale::selectRaw('article_id, count(*) as count')
        ->groupBy('article_id')
        ->get();

    // Get the total number of sales per category
    $totalSalesPerCategory = Sale::join('articles', 'sales.article_id', '=', 'articles.id')
        ->join('categories', 'articles.category_id', '=', 'categories.id')
        ->selectRaw('categories.name, count(*) as count')
        ->groupBy('categories.name')
        ->get();

    // Get the total number of sales per period
    $totalSalesPerPeriod = Sale::selectRaw('period(created_at) as period, count(*) as count')
        ->groupBy('period')
        ->get();

    return view('statistics', compact('totalSalesPerDay', 'totalSalesPerArticle', 'totalSalesPerCategory', 'totalSalesPerPeriod'));
}


}
