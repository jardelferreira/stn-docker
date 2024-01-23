@extends('adminlte::page')

@section('title', 'Documentos')

@section('content_header')
    <h1>Listagem de Documentos - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.documents.create') }}" role="button">Criar novo documento- <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($documents))
        <div class="table">
            <table class="display" id="documents" style="width: 100%">
                <thead class="thead-dark">
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
                    {{-- @foreach ($documents as $document)
                        <tr>
                            <td>{{ $document->name }}</td>
                            <td>{{ $document->description }}</td>
                            <td>{{ $document->status }}</td>
                            <td>{{ $document->type }}</td>
                            <td>
                                <a href="{{ $document->arquive }}" target="_blank">Ver Arquivo</a>
                            </td>
                            <td>{{ $document->expiration }}</td>
                            <td>{{ $document->serie }}</td>
                            <td>{{ $document->complements }}</td>
                        </tr>
                    @endforeach --}}
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
        function getDateNow() {
            // Cria um objeto Date representando o momento atual
            let dataAtual = new Date();

            // Obtém os componentes da data
            let dia = dataAtual.getDate();
            let mes = dataAtual.getMonth() + 1; // Os meses começam do zero
            let ano = dataAtual.getFullYear();

            // Formata a data como "DD/MM/AAAA"
            return Date(`${ano}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}`);

        }

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
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
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
                                return `<a href="http://localhost/dashboard/documentos/${data}/arquivo" class="font-weight-bold btn btn-outline-danger btn-sm"
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
