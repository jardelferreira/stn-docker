@extends('adminlte::page')

@section('title', 'Documentos')

@section('content_header')
    <h1>Listagem de Documentos - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.documents.create') }}" role="button">Criar novo documento- <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close bg-dark" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Sucesso!</strong> {{ session('success') }}
        </div>
    @endif
    @if (count($documents))
        <div class="table">
            <table class="display" id="documents" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Descrição</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Expiração</th>
                        <th class="text-center">Série</th>
                        <th class="text-center mx-0 px-0">Arquivo</th>
                        <th class="text-center">Ações</th>
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
    <div class="modal fade exampleModal-lg" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vincular documentos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.documents.stoksAvailable') }}" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="document_id" class="form-control" id="document_id">
                        <div class="form-group">
                            <label for="sector_id">Selecione o setor do estoque</label>
                            <select class="custom-select" name="sector_id" id="sector_id">
                                @foreach ($projects as $project)
                                    @foreach ($project->bases as $base)
                                        @foreach ($base->sectors as $sector)
                                            <option value="{{ $sector->id }}">{{ $project->name }} => {{ $base->name }}
                                                => {{ $sector->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Ir para estoque</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade exampleModal-lg" id="desvincularModal" tabindex="-1" role="dialog"
    aria-labelledby="desvincularModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="desvincularModalLabel">Desvincular Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.documents.stoksAttached') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="document_id" class="form-control" id="document_id">
                    <div class="form-group">
                        <label for="sector_id">Selecione o setor do estoque</label>
                        <select class="custom-select" name="sector_id" id="sector_id">
                            @foreach ($projects as $project)
                                @foreach ($project->bases as $base)
                                    @foreach ($base->sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $project->name }} => {{ $base->name }}
                                            => {{ $sector->name }}</option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Ir para estoque</button>
            </div>
            </form>
        </div>
    </div>
</div>
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
                    order: [0, 'asc'],
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                    columns: [{
                            className: 'dt-control',
                            orderable: true,
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
                            className: "text-center",
                            data: "id",
                            render: function(data, type) {
                                return `<a href="http://localhost/dashboard/documentos/${data}/arquivo" class="font-weight-bold btn text-danger my-0 mx-1 px-1 py-0"
                                target="_blank"><i class="fa fa-file-pdf fa-xl" aria-hidden="true"></i></a>`
                            }
                        }, {
                            data: "id",
                            render: function(data, type) {
                                return `<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="${data}">Vincular</button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#desvincularModal" data-whatever="${data}">Desvincular</button>`
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
            }
        });
        $('.modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var document_id = $(e.relatedTarget).data('whatever');

            document.querySelectorAll("input[name='document_id']").forEach((e) => e.value = document_id)

        });
    </script>
    <script>
        $(".alert").ready(function() {
            setTimeout(() => {
                $(".alert-success").fadeOut(1000)
            }, 3000);
        })
    </script>
@endsection
