@extends('adminlte::page')

@section('title', 'Cadastro de Notas')

@section('content_header')
    <h1>Cadastro de Produtos na Nota {{ $invoice->name }}</h1>
    <div class="row">
        <button id="add" class="btn btn-success">Adicionar Item</button>
        <button type="button" id="btn-submit" class="btn btn-primary ml-2">Finalizar e Cadastrar</button>
        <p class="mr-2 my-2">Total de <span id="total"> {{ old() ? old('cont') : 0 }} </span> itens para serem
            cadastrados</p>
    </div>
@stop

@section('content')
    <form id="myform">
        @csrf
        @method('POST')

        <input type="hidden" name="cont" id="cont" value="1">

        <div class="itens border border-dark p-1 rounded">
            <div class="row">
                <div class="form-group col-12">
                    <label for="product_id">Identifique o Produto</label>
                    <select class="form-control" name="product_id" id="product_id">
                        <option>Selecione...</option>
                    </select>
                </div>
            </div>
            <div class="row p-0">
                <div class="form-group col-lg-1 col-md-2 col-sm 6">
                    <label for="qtd">Qtd.</label>
                    <input type="number" class="form-control" name="qtd" id="qtd"
                        aria-describedby="qtdHelp" placeholder="10.0">
                    <small id="qtdHelp" class="form-text text-muted">Quantidade</small>
                </div>
                <div class="form-group">
                  <label for="und">Und.:</label>
                  <select  class="form-control" name="und" id="und">
                    <option value="UND">UND.</option>
                    <option value="CJT">CJT.</option>
                    <option value="PAR">PAR</option>
                    <option value="CX.">CX.</option>
                    <option value="PÇ">PÇ</option>
                    <option value="KG">KG</option>
                    <option value="TON">TON</option>
                    <option value="LITRO">LITRO</option>
                    <option value="METRO">METRO</option>
                    <option value="METRO²">METRO²</option>
                    <option value="METRO³">METRO³</option>
                  </select>
                </div>
                <div class="form-group col-lg-5 col-md-8 col-sm-12">
                    <label for="name">Item</label>
                    <input type="text"  class="form-control" name="name" id="name"
                        aria-describedby="nameHelp" placeholder=" nome do meu produto aqui">
                    <small id="nameHelp" class="form-text text-muted">Informe o nome do produto</small>
                </div>
                <div class="form-group col-lg-2 col-md-6 col-sm-6">
                    <label for="value_unid">Valor Unitário</label>
                    <input type="text"  class="form-control" name="value_unid" id="value_unid"
                        aria-describedby="value_unidHelp" placeholder="10.0">
                    <small id="value_unidHelp" class="form-text text-muted">Valor unitário</small>
                </div>
                <div class="form-group col-lg-2 col-md-6 col-sm-6">
                    <label for="ca_number">Certificado</label>
                    <input type="text"  class="form-control" name="ca_number" id="ca_number"
                        aria-describedby="ca_numberHelp" placeholder="CA-10321">
                    <small id="ca_numberHelp" class="form-text text-muted">Identificação do certificado</small>
                </div>
                <input type="hidden" class="form-control value_total" name="value_total" id="value_total"
                    aria-describedby="value_totalHelp" placeholder="10.0">
                <div class="form-group col-12">
                    <label for="description">Descrição do Item</label>
                    <input type="text" class="form-control" name="description" id="description"
                        aria-describedby="descriptionHelp" placeholder="Detalhe o produto aqui">
                    <small id="descriptionHelp" class="form-text text-muted">Descreva o produto</small>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <table class="table table-striped" id="mytable">
        <thead class="bg-warning">
            <tr>
                <th>#</th>
                <th>Action</th>
                <th>Qtd.</th>
                <th>Unidade</th>
                <th>Item</th>
                <th>Valor Unitário</th>
                <th>Certificado</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop

@section('css')
    <style>
        #total {
            z-index: 0;
            color: red;
        }
        span{
            font-weight: bold;
        }
        .fa-trash:hover{
            cursor: pointer;
        }
    </style>
@stop

@section('js')

    {{-- <script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var data_form = [];
        var table_products = document.getElementById("mytable");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#add").on("click", () => {

            new_product = $('#myform').serializeArray();

            data_form.push(new_product);
            row = table_products.insertRow()
            cell = row.insertCell()
            cell.innerText = data_form.length
            cell = row.insertCell()
            icon = document.createElement('i')
            icon.classList.add("fa")
            icon.classList.add("fa-trash")
            icon.classList.add("text-danger")
            icon.setAttribute('aria-hidden', true)
            icon.setAttribute('product', data_form.length - 1)
            icon.addEventListener("click", (e) => {
                clearTable()
                data_form.splice(e.target.getAttribute("product"), 1)
                loadTable()
            })
            cell.append(icon)

            for (let index = 4; index < 9; index++) {
                cell = row.insertCell()
                cell.innerText = new_product[index].value;

            }
            document.querySelector('span[id="total"]').innerText = data_form.length;
        })

        function removeItem(index_p) {
            console.log(data_form[index_p])
            console.log(data_form[index_p].name)
            clearTable()
            data_form.splice(index_p, 1)
            loadTable()
            document.querySelector('span[id="total"]').innerText = data_form.length;
        }

        function clearTable() {
            while (table_products.rows.length > 1) {
                table_products.deleteRow(1)
            }
            document.querySelector('span[id="total"]').innerText = data_form.length;
        }

        function loadTable() {
            data_form.forEach((element, i2) => {
                row = table_products.insertRow()
                cell = row.insertCell()
                cell.innerText = i2 + 1
                cell = row.insertCell()
                icon = document.createElement('i')
                icon.classList.add("fa")
                icon.classList.add("fa-trash")
                icon.classList.add("text-danger")
                icon.setAttribute('aria-hidden', true)
                icon.setAttribute('product', i2)
                icon.addEventListener("click", () => {
                    removeItem(icon.getAttribute('product'), 1)
                })
                cell.append(icon)
                for (let i3 = 4; i3 < 9; i3++) {
                    cell = row.insertCell()
                    cell.innerText = element[i3].value;

                }
            });
            document.querySelector('span[id="total"]').innerText = data_form.length;
        }

        btnSubmit = document.getElementById("btn-submit")
        btnSubmit.addEventListener("click", (e) => {
            e.preventDefault();
            
            request = data_form.map((data) => data.map(({name,value}) => ({[name]: value})));
            produtos = {}
            request.forEach((elemento1,index1) => {
                    produtos[index1] = {};
                        elemento1.forEach((elemento2,index2) => {
                            for (const [key, value] of Object.entries(elemento2)) {
                                produtos[index1][key] = value;
                            }
                        })
                    })

            Swal.fire({
                title: "enviando produtos",
                html: `<div id='response'>Aguarde...</div>`,
                didOpen: () => {
                    Swal.showLoading()
                    $.ajax({
                        method: "POST",
                        data: {
                            data: produtos
                        },
                        url: window.location.href,
                        success: (response) => {
                            if (response.success) {
                                Swal.fire({
                                    icon: response.type,
                                    title: response.message,
                                    text: response.event,
                                    footer: response.footer
                                }).then(() => {
                                    window.location.reload()
                                })

                            } else {
                                Swal.fire({
                                    icon: response.type,
                                    title: response.message,
                                    text: response.event,
                                    footer: response.footer
                                })
                            }
                        }
                    })
                }

            })
            // form.submit();
        })

        var global_products;
        $(window).on("load", function() {
            // Run code
            $("#product_id").select2({
                ajax: {
                    url: `${window.location.href.substring('dashboad',window.location.href.indexOf('/dashboard'))}/api/products`,
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                        };
                    },
                    processResults: function(response) {

                        let products = response.map(function(e) {
                            return {
                                "id": e.id,
                                "text": e.description
                            }
                        })

                        global_products = products;

                        return {
                            results: products
                        };
                    },
                    cache: true
                }
            });

            $("#myform").validate({
                rules: {
                    product_id: {
                        required: true,
                        digits: true
                    },
                    qtd: {
                        required: true,
                        digits: true
                    },
                    und: {
                        required: true,
                        digits: true
                    },
                    // u_email: {
                    //     required: true,
                    //     email: true,//add an email rule that will ensure the value entered is valid email id.
                    //     maxlength: 255,
                    // },
                }
            });

        });
        $('#value_unid').mask('#.##0,00', { reverse: true });
        // $("#value_unid").inputmask('currency', {
        //         "autoUnmask": true,
        //         radixPoint: ",",
        //         groupSeparator: ".",
        //         allowMinus: false,
        //         prefix: 'R$ ',
        //         digits: 2,
        //         digitsOptional: false,
        //         rightAlign: true,
        //         unmaskAsNumber: true
        //     });
    </script>
@stop
