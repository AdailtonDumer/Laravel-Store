@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @forelse($carts as $cart)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th class="text-center">Preço</th>
                                <th class="text-center">Total</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->products as $product)
                                <tr>
                                    <td class="col-sm-8 col-md-6">
                                        <div class="media"><a href="#" class="thumbnail pull-left"><img
                                                    src="{{$product->url}}" class="media-object"
                                                    style="width: 72px; height: 72px;"></a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="#">{{$product->title}}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-sm-1 col-md-1" style="text-align: center;"><input type="quantity"
                                            id="quantity" value="{{$product->pivot->quantity}}" class="form-control"></td>
                                    <td class="col-sm-1 col-md-1 text-center"><strong id="subtotal">{{$product->pivot->sub_total}}</strong></td>
                                    <td class="col-sm-1 col-md-1 text-center"><strong id="total">{{$product->pivot->quantity * $product->pivot->sub_total}}</strong></td>
                                    <td class="col-sm-1 col-md-1"><button type="button"
                                            class="btn btn-sm btn-outline-danger">
                                            Excluir
                                        </button></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3"> &nbsp; </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td class="text-right">
                                    <h5><strong>{{$cart->sub_total}}</strong></h5>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"> &nbsp; </td>
                                <td>
                                    <h5>Frete</h5>
                                </td>
                                <td class="text-right">
                                    <h5><strong>{{$cart->shipping}}</strong></h5>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"> &nbsp; </td>
                                <td>
                                    <h3>Total</h3>
                                </td>
                                <td class="text-right">
                                    <h3><strong>{{$cart->total}}</strong></h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="div-calc">
                            <div class="loader"></div>
                            <form id="form-calc" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="zipcode" name="zipcode" maxlength="8" class="form-control" id="zipcode" placeholder="Digite seu Cep">
                                </div>
                                <button type="button" id="calc" class="btn btn-primary mb2">Calcular Frete</button>
                            </form>

                        </div>
                    <div class="float-right"><a href="#" class="btn btn-sm btn-outline-secondary">
                            Continuar Comprando
                        </a> <button type="button" class="btn btn-sm btn-outline-success">
                            Comprar
                        </button></div>
                    @empty
                        <h3 style="text-align: center;">Carrinho Vazio</h3>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
$(document).ready(function(){
    $('#calc').on('click', function(){
        let cepDestination = $('#zipcode').val();
        let url = '{{ route("store.shipping",["cep"=> "_cep", "order" => $cart->id]) }}'.replace('_cep', cepDestination)
        console.log(url)
        if(cepDestination.length == 8){
            $.get(url)
            .then(function(data){
                let html = ''
                html = '<ul class"list-group list-group-flish">'
                $.each(data, function(i){
                    html += '<li class="list-group-item">'+data[i].tipo+' | '+data[i].prazo_entrega+' Dias | R$ '+data[i].valor+'</li>'
                })
                html += '</ul>'

                $('#div-calc').html(html);
            })
        }
    })
})
</script>

@endsection