<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $carts = Order::where('user_id', Auth::id())->latest()->limit(1)->get();

        return view('store.cart.index', compact('carts'));
    }

    public function store(Request $request, Product $product){
        $carts = Order::firstOrCreate([
            'status' => Order::STATUS_CREATED,
            'user_id'=>Auth::id()
        ]);
        $carts->products()->attach($product->id,[
            'quantity' => 1,
            'sub_total' => $product->amount
        ]);
        return redirect()->route('cart.index')->with('success','Produto Adicionado com sucesso');
    }
}
