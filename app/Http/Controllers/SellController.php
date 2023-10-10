<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use App\Http\Controllers\Request;




class SellController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->get();
        return view('dashboard', compact('categories'));
    }

    
   public function create(Article $article)

    {
        
    }

    public function store(Request $request)
    {

    }

    public function cart()
    {
        // ici je récupère les ventes en cours
    }
}
