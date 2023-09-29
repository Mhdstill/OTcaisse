<?php

namespace App\Http\Controllers;

use App\Models\Category;



class SellController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->get();
        return view('dashboard', compact('categories'));
    }
}
