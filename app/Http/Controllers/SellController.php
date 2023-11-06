<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SellController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->get();
        $selectedArticles = session('selectedArticles', []);
        $total = 0;
        foreach ($selectedArticles as $article) {
        $total += $article->price;
        }
    return view('dashboard', compact('categories', 'total'));
    }


    // public function create(Article $article)
    // {
    //     $articles = Article::all();
    //     $sale = new Sale;
    //     return view('cart', compact('article', 'articles', 'sale'));
    // }

    public function add(Request $request, Article $article)
{
    $selectedArticles = $request->session()->get('selectedArticles', []);
    if (isset($selectedArticles[$article->id])) {
        $selectedArticles[$article->id]->quantity += 1;
    } else {
        $article->quantity = 1;
        $selectedArticles[$article->id] = $article;
    }
    $request->session()->put('selectedArticles', $selectedArticles);
    return redirect()->back();
}
public function remove(Request $request, Article $article)
{
    $selectedArticles = $request->session()->get('selectedArticles', []);
    if (isset($selectedArticles[$article->id]) && $selectedArticles[$article->id]->quantity > 1) {
        $selectedArticles[$article->id]->quantity -= 1;
    } else {
        unset($selectedArticles[$article->id]);
    }
    $request->session()->put('selectedArticles', $selectedArticles);
    return redirect()->back();
}
public function update(Request $request, Article $article)
{
    $selectedArticles = $request->session()->get('selectedArticles', []);
    if (isset($selectedArticles[$article->id])) {
        $selectedArticles[$article->id]->quantity = $request->quantity;
    }
    $request->session()->put('selectedArticles', $selectedArticles);
    return redirect()->back();
}

    public function confirm(Request $request)
    {
        $selectedArticles = $request->session()->get('selectedArticles', []);
        return view('confirm', compact('selectedArticles'));
    }

    public function store(Request $request)
    {
        $selectedArticles = $request->session()->get('selectedArticles', []);
        foreach ($selectedArticles as $article) {
            Sale::create([
                'article_id' => $article->id,
                'quantity' => $article->quantity,
                'price' => $article->price,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
            ]);
        }
        $request->session()->forget('selectedArticles');
        return redirect()->route('success');
    }
}