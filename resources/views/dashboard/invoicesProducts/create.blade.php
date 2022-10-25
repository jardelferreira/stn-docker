@extends('adminlte::page')

@section('title', 'Cadastro de Notas')

@section('content_header')
    <h1>Cadastro de Produtos na Nota {{ $invoice->name }}</h1>
    <div class="row">
        <button id="add" class="btn btn-success">Adicionar Item</button>
        <button type="button" id="btn-submit" class="btn btn-primary ml-2">Finalizar e Cadastrar</button>
        <p class="mr-2 my-auto" id="total">Total de <span> {{old() ? old('cont'): 0}} </span>itens para serem cadastrados</p>
    </div>
@stop

@section('content')
    @if (old())
        <form action="{{ route('dashboard.invoices.popular.store', ['invoice' => $invoice->id]) }}" method="post"
            autocomplete="off" enctype="multipart/form-data" id="myform">
            @csrf
            @method('POST')

            <input type="hidden" name="cont" id="cont" value="{{ old('cont') }}">
            @for ($i = 0; $i < old('cont'); $i++)
            <div class="itens">
                    <hr>
                    <button id="rmv" type="button" class="btn btn-danger mr-0"><i class="fa fa-trash"
                            aria-hidden="true" disable></i></button>
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="qtd[]">Qtd.</label>
                            <input type="number" required="required" class="form-control" name="qtd[]" id="qtd[]"
                                aria-describedby="qtdHelp" value="{{old('qtd')[$i]}}" placeholder="10.0">
                            <small id="qtdHelp" class="form-text text-muted">Informe uma quantidade</small>
                        </div>
                        <div class="form-group col-2">
                            <label for="und[]">Und.</label>
                            <input type="text" required class="form-control" name="und[]" id="und[]"
                                aria-describedby="undHelp" placeholder="Ex: PÇ" value="{{old('und')[$i]}}">
                            <small id="undHelp" class="form-text text-muted">EX: PÇ,M. Ton, M²</small>
                        </div>
                        <div class="form-group col-5">
                            <label for="name[]">Item</label>
                            <input type="text" required class="form-control" name="name[]" id="name[]" value="{{old('name')[$i]}}"
                                aria-describedby="nameHelp" placeholder=" nome do meu produto aqui">
                            <small id="nameHelp" class="form-text text-muted">Informe o nome do produto</small>
                        </div>
                        <div class="form-group col-2">
                            <label for="value_unid[]">Valor Unitário</label>
                            <input type="number" required class="form-control" name="value_unid[]" id="value_unid[]" value="{{old('value_unid')[$i]}}"
                                aria-describedby="value_unidHelp" placeholder="10.0">
                            <small id="value_unidHelp" class="form-text text-muted">Valor unitário</small>
                        </div>
                        <div class="form-group col-2">
                    <label for="value_total[]">Valor Total</label>
                    <input type="hidden" class="form-control value_total" name="value_total[]" id="value_total[]"
                        aria-describedby="value_totalHelp" placeholder="10.0" value="{{old() ?? floatVal(old('value_unid')) * floatVal(old('qtd'))}}">
                    <small id="value_totalHelp" class="form-text text-muted">Valor total</small>
                </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="description[]">Descrição do Item</label>
                        <input type="text" class="form-control" name="description[]" id="description[]" value="{{old('description')[$i] ?? ""}}"
                            aria-describedby="descriptionHelp" placeholder="Detalhe o produto aqui">
                        <small id="descriptionHelp" class="form-text text-muted">Descreva o produto</small>
                    </div>
                </div>
            @endfor
        </form>
    @else
        <form action="{{ route('dashboard.invoices.popular.store', ['invoice' => $invoice->id]) }}" method="post"
            autocomplete="off" enctype="multipart/form-data" id="myform">
            @csrf
            @method('POST')

            <input type="hidden" name="cont" id="cont" value="1">

            <div class="itens">
                <button id="rmv" type="button" class="btn btn-danger mr-0"><i class="fa fa-trash" aria-hidden="true"
                        disable></i></button>
                <hr>
                <div class="row">
                    <div class="form-group col-2">
                        <label for="qtd[]">Qtd.</label>
                        <input type="number" required="required" class="form-control" name="qtd[]" id="qtd[]"
                            aria-describedby="qtdHelp" placeholder="10.0">
                        <small id="qtdHelp" class="form-text text-muted">Informe uma quantidade</small>
                    </div>
                    <div class="form-group col-2">
                        <label for="und[]">Und.</label>
                        <input type="text" required class="form-control" name="und[]" id="und[]"
                            aria-describedby="undHelp" placeholder="Ex: PÇ">
                        <small id="undHelp" class="form-text text-muted">EX: PÇ,M. Ton, M²</small>
                    </div>
                    <div class="form-group col-5">
                        <label for="name[]">Item</label>
                        <input type="text" required class="form-control" name="name[]" id="name[]"
                            aria-describedby="nameHelp" placeholder=" nome do meu produto aqui">
                        <small id="nameHelp" class="form-text text-muted">Informe o nome do produto</small>
                    </div>
                    <div class="form-group col-2">
                        <label for="value_unid[]">Valor Unitário</label>
                        <input type="number" required class="form-control" name="value_unid[]" id="value_unid[]"
                            aria-describedby="value_unidHelp" placeholder="10.0">
                        <small id="value_unidHelp" class="form-text text-muted">Valor unitário</small>
                    </div>
                    <input type="hidden" class="form-control value_total" name="value_total[]" id="value_total[]"
                        aria-describedby="value_totalHelp" placeholder="10.0">
                <div class="form-group col-12">
                    <label for="description[]">Descrição do Item</label>
                    <input type="text" class="form-control" name="description[]" id="description[]"
                        aria-describedby="descriptionHelp" placeholder="Detalhe o produto aqui">
                    <small id="descriptionHelp" class="form-text text-muted">Descreva o produto</small>
                </div>
            </div>
        </form>
    @endif



@stop

@section('css')
    <style>
        #cont>span {
            z-index: 0;
        }
    </style>
@stop

@section('js')
    <script>
        classes = ["primary", "secondary", "success", "info", "warning", "danger", "light", "dark"]
        form = document.getElementById("myform")
        itens = document.querySelector(".itens");
        add = document.getElementById("add");
        btnSubmit = document.getElementById("btn-submit")
        btnSubmit.addEventListener("click", (e) => {
            e.preventDefault();
            form.submit();
        })

        add.addEventListener("click", (e) => {

            clone = itens.cloneNode(true);
            classe = classes[Math.floor(Math.random() * classes.length)];
            clone.classList.add(`bg-${classe}`);
            form.prepend(clone);
            qtd = document.getElementsByClassName("itens");
            document.getElementById("cont").value = qtd.length;
            document.querySelector("#total > span").innerText = ` ${qtd.length} `
            rm = document.getElementById("rmv");
            rm.addEventListener("click", (e, i) => {
                e.preventDefault()
                if (e.target.parentNode.tagName == "DIV") {
                    console.log(`Clicou na ${e.target.parentNode.tagName}`)
                    e.target.parentNode.remove()
                } else {
                    e.target.parentNode.parentNode.remove()
                    console.log(`Clicou na ${e.target.parentNode.tagName}`)
                }
                qtd = document.getElementsByClassName("itens");
                document.getElementById("cont").value = qtd.length;
                document.querySelector("#total > span").innerText = ` ${qtd.length} `
            })
        })
        document.addEventListener("DOMContentLoaded", function(event) {
            rm = document.getElementById("rmv");
            rm.addEventListener("click", (e, i) => {
                if (e.target.parentNode.tagName == "DIV") {
                    console.log(`Clicou na ${e.target.parentNode.tagName}`)
                    e.target.parentNode.remove()
                } else {
                    e.target.parentNode.parentNode.remove()
                    console.log(`Clicou na ${e.target.parentNode.tagName}`)
                }
                qtd = document.getElementsByClassName("itens");
                document.getElementById("cont").value = qtd.length;
                document.querySelector("#total > span").innerText = ` ${qtd.length} `
            })
        });
    </script>
@stop
