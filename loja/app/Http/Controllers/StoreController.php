<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Shipping\CorreioApi;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(){
        $products = Product::paginate();

        return view('welcome', compact('products'));
    }
    public function shipping($cep, Order $order){
        return (new CorreioApi)->makeRequestShipping($cep,$order->products)->prices();
    }
}
