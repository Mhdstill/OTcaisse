<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    // fct used to create a new sale entry in the database when a user submits a form to sell an article. 
    // It creates a new Sale model instance and saves it to the database.
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

//     public function confirmPurchase(Request $request)
//     // this fct is responsible 4: confirming a sale and updating the status of the sale in the database. 
//     // It also updates the quantity of the sold articles in the Article model.
// {
//     $validData = $request->validate([
//         'sale_id' => 'required|integer|exists:sales,id',
//     ]);

//     $sale = Sale::find($validData['sale_id']);
//     $sale->status = 'confirmed';
//     $sale->save();

//     $soldArticles = Session::get('cart', []);
//     foreach ($soldArticles as $articleId => $article) {
//         $articleModel = Article::find($articleId);
//         if ($articleModel) {
//             $articleModel->quantity -= $article['quantity'];
//             $articleModel->save();
//         }
//     }

//     // Clear the cart
//     Session::forget('cart');

//     return redirect()->route('dashboard')->with('success', 'La vente a bien été enregistrée');
// }
//  try 07 nov
public function confirmPurchase(Request $request)
{
    $cart = Session::get('cart', []);

    // Check if at least one payment method is selected
    $paymentMethods = $request->input('payment_method');
    if (empty($paymentMethods)) {
        return redirect()->route('cart')->with('error', 'Veuillez choisir un moyen de paiement.');
    }

    DB::beginTransaction();

    try {
        foreach ($cart as $articleId => $details) {
            $article = Article::find($articleId);

            if (!$article || $article->quantity < $details['quantity']) {
                return redirect()->route('cart')->with('error', 'Article not available in the required quantity.');
            }

            $sale = new Sale;
            $sale->article_id = $article->id;
            $sale->quantity = $details['quantity'];
            $sale->price = $details['price'];
            $sale->status = 'active';
            $sale->save();

            $article->quantity -= $details['quantity'];
            $article->save();

            // Handle payment methods
            $paymentMethods = $request->input('payment_method');
            foreach ($paymentMethods as $method) {
                $amount = $request->input('amount_' . $method);
                $comment = $request->input('comment_' . $method);

                if ($amount > 0) {
                    $payment = new Payment;
                    $payment->sale_id = $sale->id;
                    $payment->method = $method;
                    $payment->amount = $amount;
                    $payment->comment = $comment;
                    $payment->save();
                }
            }
        }

        Session::forget('cart');

        DB::commit();

        return redirect()->route('dashboard')->with('success', 'Purchase confirmed successfully!');
    } catch (\Exception $e) {
        DB::rollback();

        return redirect()->route('cart')->with('error', 'There was a problem confirming the purchase.');
    }
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
        $quantity++;
        $cart[$articleId] = [
            'quantity' => $quantity,
        ];
    }

    Session::put('cart', $cart);

    return Redirect::route('cart')->with('success', 'Article ajouté au panier avec succès !');
}

  
    public function cart()
{
    $cart = Session::get('cart', []);
    $selectedArticles = Article::whereIn('id', array_keys($cart))->get();
    
    return view('cart', compact('cart','selectedArticles'));
}

}





//     public function addToCart(Request $request)
// {
    // ANCIEN CODE ////////
    //$articleId = $request->input('articleId');
    //$quantity = $request->input('quantity');
    //$price = $request->input('price');
    //$cart = Session::get('cart', []);
    //if (isset($cart[$articleId])) {
    //    $cart[$articleId]['quantity'] += $quantity;
    //} else {
    //    $cart[$articleId] = [
    //        'quantity' => $quantity,
    //        'price' => $price,
    //    ];
    //}
    //
    //Session::put('cart', $cart);

    // CODE PAUL ////////
    // On récupère le tableau qui contient les ID des articles séléctionnés
    // Le tableau s'appel "selected_articles" parce qu'il correspond au nom de l'input dans le formulaire (dashboard.blade.php - L14)
    // $articleIds = $request->input('selected_articles');

    // On récupère le contenu du panier de l'utilisateur (dans la session "CART")
    // $cart = Session::get('cart', []);
    // Dans le code que j'ai fait, on stock les articles en session de cette manière :
    // ID ARTICLE => QUANTITE
    // Ex : [1 => 5, 2 => 3]

    // On boucle sur chaque ID d'article présent dans le tableau (= chaque article séléctionné par l'utilisateur)
    // foreach ($articleIds as $articleId) {
        // Si il y a déjà cet ID d'article en session, alors on incrémente sa quantité de 1
        // Sinon, on l'ajoute au panier avec une quantité initiale de "1"
    //     if (isset($cart[$articleId])) {
    //         $cart[$articleId] = $cart[$articleId] + 1;
    //     } else {
    //         $cart[$articleId] = 1;
    //     }
    // }

    // On met à jour notre session avec le contenu du panier de l'utilisateur
//     Session::put('cart', $cart);

//     return Redirect::route('cart')->with('success', 'Article ajouté au panier avec succès !');
// }