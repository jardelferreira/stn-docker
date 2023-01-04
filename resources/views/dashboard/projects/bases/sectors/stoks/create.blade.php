@extends('adminlte::page')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Cadastro de Setores')

@section('content_header')
    <h1>Adicionar produtos ao Estoque do Setor - <small>{{ $sector->name }}</small></h1>
@stop

@section('content')
    <form action="#" id="produtos" method="post" class="row container">
        
        <div class="form-group col-sm-12 col-md-8 col-lg-8 mx-1">
            <label for="provider_id">Fornecedor:</label>
            <select class="form-control" name="provider_id " id="provider_id"></select>
        </div>
        <div class="form-group col-sm-12 col-md-3 col-lg-3 mx-1">
            <label for="invoice_id">Número da nota:</label>
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
</div>
    <table class="table table-strped tabelaEditavel" id="{{ $sector->id }}">
        <thead>
            <tr>
                <th>#</th>
                <th>Produto</th>
                <th>Und</th>
                <th>Qtd em NF</th>
                <th>Qtd disponível</th>
                <th>Qtd Para adicionar</th>
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
            var url = window.location.href;

            $("#provider_id").select2({
                ajax: {
                    url: `${url}/providers`,
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
                    url: `${url}/providers/invoices`,
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
                $("#produtos tr").remove();
                if (invoice) {
                    $("tbody").html = ""
                    $.ajax({
                            method: "GET",
                            url: `${url}/invoice/${invoice}/products`,
                        })
                        .done(function(data) {
                            if (!data.length) {
                                alert("NF não tem produto disponível");
                            } else {

                                data.forEach(product => {
                                    if (parseFloat(product.qtd_available) <= 0) {
                                        $("tbody").append(`<tr  id='${product.id}'>
                                            <td><input class="form-check-input" name="" id="" type="checkbox" value="checkedValue" aria-label="Text for screen reader"></td>
                                            <td>${product.description}</td>
                                        <td>${product.und}</td>
                                        <td>${product.qtd}</td>                                    
                                        <td >Sem estoque</td> 
                                        <td><button type="button" class="btn mr-1 btn-success btn-sm">Ação</button></td>                                                                       
                                        </tr>`)
                                    } else {
                                        $("tbody").append(`<tr  id='${product.id}'>
                                            <td><input class="form-check-input mx-2" name="" id="" type="checkbox" value="checkedValue" aria-label="Text for screen reader"></td>
                                            <td>${product.description}</td>
                                            <td>${product.und}</td>
                                            <td>${product.qtd}</td>                                    
                                            <td>${product.qtd_available}</td> 
                                            <td class='editavel'>Clique duas vezes</td> 
                                            <td><button type="button" class="btn mr-1 btn-success btn-sm">Ação</button></td>                                                                       
                                            </tr>`)

                                    }
                                });
                            }
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
            $("#add_all, #add_selected").on("click", (e) => addStok(e));

            function addStok(event) {
                let dados = {};
                dados.products = [];
                dados._token = $('meta[name="csrf-token"]').attr('content');
                dados.sector = parseInt($('table').attr("id"))
                if (event.target.id == "add_selected") {
                    $("tbody > tr").each((index1, tr) => {
                        if ($(tr).find(`input[type='checkbox']`).prop('checked')) {
                            dados.products.push({
                                sector: parseInt($('table').attr("id")),
                                id: parseInt($(tr).attr("id")),
                                qtd: parseFloat($(tr).children()[4].innerText)
                            })
                        }
                    })

                } else {
                    $("tbody > tr").each((index1, tr) => {
                        dados.products.push({
                            sector: parseInt($('table').attr("id")),
                            id: parseInt($(tr).attr("id")),
                            qtd: parseFloat($(tr).children()[4].innerText)
                        })
                    })

                }
                // objeto montado com os dados

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                console.log(dados.products);
                $.post(`${url}/product/store`, dados,
                    function(data, status) {
                        console.log(data)
                        alert("Data: " + data + "\nStatus: " + status);
                        $("#produtos tr").remove();
                    });
            } // fim addStok

        });
    </script>
@stop
