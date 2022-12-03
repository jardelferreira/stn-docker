@extends('adminlte::page')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Cadastro de Setores')

@section('content_header')
    <h1>Adicionar produtos ao Estoque do Setor - <small>{{ $sector->name }}</small></h1>
@stop

@section('content')
    <form action="#" id="produtos" method="post"></form>
    <div class="form-group">
        <label for="provider_id">Fornecedor</label>
        <select class="form-control" name="provider_id " id="provider_id"></select>
    </div>
    <div class="form-group">
        <label for="invoice_id">Número da nota</label>
        <select class="custom-select" name="invoice_id" id="invoice_id">

        </select>
    </div>
    <hr>
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" id="add_all" class="btn mr-1 btn-primary">Adicionar Todos</button>
        <button type="button" id="add_selected" class="btn mr-1 btn-secondary">Adicionar Selecionados</button>
        {{-- <button type="button" id="" class="btn mr-1 btn-warning">Selecionar outra NF</button> --}}
        {{-- <button type="button" id="clear" class="btn mr-1 btn-danger">Limpar Tabela</button> --}}
    </div>
    <table class="table table-strped tabelaEditavel" id="{{ $sector->id }}" >
        <thead>
            <tr>
                <th>#</th>
                <th>Produto</th>
                <th>Und</th>
                <th>Qtd em NF</th>
                <th>Qtd disponível</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="produtos"></tbody>
    </table>
@stop

@section('css')
    <style>

    </style>
@stop

@section('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#provider_id").select2({
                ajax: {
                    url: `http://localhost/dashboard/api/providers/${parseInt($("table").attr("id"))}`,
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            sector: $("table").attr("id") // search term
                        };
                    },
                    processResults: function(response) {
                        console.log(response)
                        let providers = response.map(function(e) {
                            return {
                                "id": e.id,
                                "text": e.corporate_name
                            }
                        })
                        return {
                            results: providers
                        };
                    },
                    cache: true
                }
            });

            $("#invoice_id").select2({
                ajax: {
                    url: `http://localhost/dashboard/api/providers/invoices/${parseInt($("table").attr("id"))}`,
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            provider: parseInt(document.getElementById("provider_id").value)
                        };
                    },
                    processResults: function(response) {
                       
                        let invoices = response.map(function(e) {
                            return {
                                "id": e.id,
                                "text": e.name
                            }
                        })
                        return {
                            results: invoices
                        };
                    },
                    cache: true
                }
            });
            $("#invoice_id").on("change", (e) => {
                invoice = parseInt($('#invoice_id').val())
                if (invoice) {
                    $("tbody").html = ""
                    $.ajax({
                            method: "GET",
                            url: `http://localhost/dashboard/api/invoice/${invoice}/products`,
                        })
                        .done(function(data) {
                            data.forEach(product => {
                                $("tbody").append(`<tr  id='${product.id}'>
                                    <td><input class="form-check-input" name="" id="" type="checkbox" value="checkedValue" aria-label="Text for screen reader"></td>
                                    <td>${product.name}</td>
                                    <td>${product.und}</td>
                                    <td>${product.qtd}</td>                                    
                                    <td class='editavel'>${product.qtd}</td> 
                                    <td><button type="button" class="btn mr-1 btn-success btn-sm">Ação</button></td>                                                                       
                                    </tr>`)
                            });
                            $(".editavel").dblclick(function() {
                                var conteudoOriginal = $(this).text();

                                $(this).addClass("celulaEmEdicao");
                                $(this).html("<input type='text' value='" + conteudoOriginal +
                                    "' />");
                                $(this).children().first().focus();

                                $(this).children().first().keypress(function(e) {
                                    if (e.which == 13) {
                                        var novoConteudo = $(this).val();
                                        $(this).parent().text(novoConteudo);
                                        $(this).parent().removeClass("celulaEmEdicao");
                                    }
                                });

                                $(this).children().first().blur(function() {
                                    $(this).parent().text(conteudoOriginal);
                                    $(this).parent().removeClass("celulaEmEdicao");
                                });
                            });
                        });
                }
            })
            $("#add_all").on("click", (e) => {
                let dados = {};
                dados.products = [];
                dados._token = $('meta[name="csrf-token"]').attr('content');
                dados.sector = parseInt($('table').attr("id"))
                $("tbody > tr").each((index1, tr) => {
                    dados.products.push({
                        sector: parseInt($('table').attr("id")),
                        id: parseInt($(tr).attr("id")),
                        qtd: parseFloat($(tr).children()[4].innerText)
                    })
                })
                // objeto montado com os dados

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post("http://localhost/dashboard/api/products/store", dados,
                    function(data, status) {
                        console.log(data)
                        alert("Data: " + data + "\nStatus: " + status);
                    });
            })
        });
    </script>
@stop
