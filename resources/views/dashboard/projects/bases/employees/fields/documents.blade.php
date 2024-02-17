@extends('adminlte::page')

@section('title', 'Cadastro de registro')

@section('content_header')
    <h1 class="text-center bg-light">Documentação de item da {{ $formlist_employee->formlist->name }} - <span
            class="font-weight-bold">{{ $employee->user->name }}</span></h1>
@stop

@section('content')
    <div class="mt-1 bg-light">
        <!-- Informações do Produto -->
        <div class="card">
            <div class="card-header bg-dark text-center">
                <h4>{{$stok->invoiceProduct->description}}</h4>
              </div>
            <div class="row no-gutters">
                <div class="col-4" style="height: 250px;">
                    <img src="{{asset("images/sem-imagem.png")}}" height="100%" width="auto" class="card-img" alt="Imagem do Produto">
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Item: </strong>{{$stok->invoiceProduct->name}}</h5>
                        <p class="card-text"><strong>Descrição: </strong>{{$stok->invoiceProduct->description}}</p>
                    </div>
                    <div class="card-body mt-0">
                        <h5 class="card-title font-weight-bold">Dados Fiscais do Produto</h5>
                        <p class="card-text"><strong>NOTA: </strong>{{$stok->invoiceProduct->invoice->name}} - <a href="{{ route('dashboard.invoices.show', $stok->invoiceProduct->invoice) }}" target="_blank" class="text-danger"
                                rel="noopener noreferrer">Acessar nota <i class="fa fa-file-pdf fa-xl" aria-hidden="true"></i></a></p>
                        <p class="card-text"><strong>FORNECEDOR: </strong> {{$stok->invoiceProduct->invoice->provider->corporate_name}}</p>
                        <p class="card-text"><strong>CNPJ: </strong> {{$stok->invoiceProduct->invoice->provider->cnpj}}</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($stok->documents->count())
            <div class="table">
                <table class="display table-striped" id="documents" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Tipo</th>
                            <th>Expiração</th>
                            <th>Série</th>
                            <th>Arquivo</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            @else
                <div class="alert alert-primary" role="alert">
                    <strong>Não há documentos cadastrados</strong>
                </div>
        @endif

    @endsection
    @section('js')
        <script>
            function checkValid(expiration) {
                return new Date().getTime() < new Date(expiration).getTime() ?
                    `<span class="bg-success  mx-1 p-1">Válido</span>` : `<span class="bg-danger  mx-1 p-1">Inválido</span>`
            }
        </script>

        <script>
            function format(d) {
                // `d` is the original data object for the row
                complements = JSON.parse(d.complements)
                if (complements.length > 0) {
                    ul = document.createElement("ul")
                    ul.classList.add("list-group")
                    for (complement of complements) {
                        li = document.createElement("li")
                        span = document.createElement("span")
                        li.classList.add("list-group-item")
                        span.classList.add("text-bold")
                        text_value = document.createTextNode(complement.value)
                        text_parameter = document.createTextNode(`${complement.parameter}: `)
                        span.appendChild(text_parameter)
                        li.appendChild(span)
                        span.after(text_value)
                        // li.appendChild(span)
                        // console.log(complement.value)
                        ul.appendChild(li)
                    }
                    return (ul);
                } else {
                    return ("<dt>Sem mais informações</dt>")
                }
            }

            $.ajax({
                url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                success: function(result) {
                    let table = new DataTable('#documents', {
                        ajax: `${window.location.href}/json`,
                        responsive: true,
                        order: [0, 'desc'],
                        "language": result,
                        info: false,
                        ordering: false,
                        paging: false,
                        searching: false,
                        columns: [{
                                className: 'dt-control',
                                orderable: false,
                                data: null,
                                defaultContent: ''
                            },
                            {
                                data: 'name'
                            },
                            {
                                data: 'description'
                            },
                            {
                                className: "text-center",
                                data: 'expiration',
                                render: function(data, type) {
                                    return checkValid(data)
                                }
                            },
                            {
                                data: 'type'
                            }, {
                                data: "expiration",
                                render: function(data, type) {
                                    return new Date(data).toLocaleDateString("pt-BR")
                                }
                            }, {
                                data: "serie"
                            }, {
                                data: "id",
                                render: function(data, type) {
                                    return `<a href="https://${window.location.host}/dashboard/documentos/${data}/arquivo" class="font-weight-bold btn btn-outline-danger btn-sm"
                                target="_blank">Ver Arquivo</a>`
                                }
                            }
                        ],
                        rowId: 'id',
                        stateSave: true
                    });

                    table.on('requestChild.dt', function(e, row) {
                        row.child(format(row.data())).show();
                    });

                    // Add event listener for opening and closing details
                    table.on('click', 'td.dt-control', function(e) {
                        let tr = e.target.closest('tr');
                        let row = table.row(tr);

                        if (row.child.isShown()) {
                            // This row is already open - close it
                            row.child.hide();
                        } else {
                            // Open this row
                            row.child(format(row.data())).show();
                        }
                    });

                    // setTimeout(() => {

                    //     tds = document.querySelectorAll("tbody tr td:nth-child(4)")
                    //     tds.forEach(td => {
                    //         switch (td.innerText) {
                    //             case "valid":
                    //                 td.innerText = "Válido"
                    //                 td.classList.add("bg-success")
                    //                 td.classList.add("text-center")
                    //                 break;

                    //             default:
                    //                 break;
                    //         }
                    //     })
                    // }, 2000);
                }
            });
        </script>
    @endsection
