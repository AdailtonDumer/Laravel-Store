@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                <img class="card-img-top" src="{{$product->url}}" alt="Card image cap">
                    <p class="card-text">{{$product->description}}</p>                          
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{$product->title}}</h2>
                    <p class="card-text h3">R${{$product->amount}}</p>    
                    <hr/>
                        <div id="div-calc">
                            <div class="loader"></div>
                            <form id="form-calc" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="zipcode" name="zipcode" maxlength="8" class="form-control" id="zipcode" placeholder="Digite seu Cep">
                                </div>
                                <button type="button" id="calc" class="btn btn-primary mb2">Calcular Frete</button>
                            </form>

                        </div>
                    <hr/>                        
                    <div class="btn-group">
                        <button class="btn btn, btn-outline-success" type="button">Comprar</button>
                    </div>
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

        if(cepDestination.length == 8){
            $.get('http://localhost:8000/ws/frete',{
                cep_origem:'29780000',
                cep_destino:cepDestination,
                altura:{{$product->width}},
                comprimento:{{$product->length}},
                largura:{{$product->height}},
                peso:{{$product->weight}}
            }).then(function(data){
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