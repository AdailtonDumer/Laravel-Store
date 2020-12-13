@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="card-deck">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="{{$product->url}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$product->title}}</h5>
                            <p class="card-text">{{$product->description}}</p>
                            <p class="card-text">R${{$product->amount}}</p>                            
                            <div class="btn-group">
                                <a href="{{route('store.products.show', ['product' => $product->id])}}" class="btn btn-s, btn-outline-secondary" type="button">Visualizar</a>
                                <a href="{{route('cart.store', ['product' => $product->id])}}" class="btn btn-s, btn-outline-success" type="button">Comprar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection