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

    <div class="modal  fade updateModal-lg" id="updateModal" tabindex="-1" role="dialog"
        aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Atualizar Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dashboard.documents.store') }}" method="POST" enctype="multipart/form-data"
                    id="myform" name="myform" class="form border mb-1">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label for="type">Tipo:</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type"
                                onclick="" name="type" required>
                                <option value="">Selecione...</option>
                                @foreach ($types as $type => $value)
                                    <option value="{{ $type }}">{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Nome do documento" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="status">Status:</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status" required>
                                <option value="">Selecione...</option>
                                @foreach ($statuses as $status => $value)
                                    <option value="{{ $status }}">{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição:</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                            id="description" placeholder="descreva detalhes aqui" name="description"
                            value="{{ old('description') }}" required>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label for="expiration">Data de expiração:</label>
                            <input type="date" class="form-control @error('expiration') is-invalid @enderror"
                                id="expiration" name="expiration" value="{{ old('expiration') }}" required>
                            @error('expiration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="serie">Número de série:</label>
                            <input type="text" class="form-control @error('serie') is-invalid @enderror"
                                id="serie" placeholder="42158" name="serie" value="{{ old('serie') }}" required>
                            @error('serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="file">Arquivo</label>
                            <input type="file" class="form-control-file @error('file') is-invalid @enderror"
                                id="file" name="file" required>
                            <a href="#" id="link-file" target="_blank"
                                class="btn btn-primary form-control d-none">Clique aqui
                                para baixar o documento</a>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="complements" value="{{ old('complements') }}" id="complements">
                    <div class="row mt-2">
                        <div class="form-group mb-2 col-lg-3 col-md-3">
                            <label for="parameter">Parametro</label>
                            <input type="text" class="form-control" id="parameter" placeholder="Registro Técnico">
                        </div>
                        <div class="form-group mx-sm-3 mb-2 col-lg-3 col-md-3">
                            <label for="value">Atributo</label>
                            <input type="text" class="form-control" id="value" placeholder="XXX-548316-BR">
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="add"><small>Adicione vários (parametros: Atributos)</small></label>
                            <button type="button" class="btn btn-success mb-0 form-control" id="add">Adicionar
                                Complemento</button>
                        </div>
                        <div class="form-group col-lg3 col-md-2">
                            <label for="add"><small>Limpar complementos</small></label>

                            <button type="button" onclick="clearTable()" class="ml-2 btn btn-info ml-1"
                                id="clear">Limpar
                                Comlementos</button>
                        </div>
                        <hr>
                    </div>
                    <button type="submit" class="btn btn-primary ml-1" id="submit">Finalizar cadastro de
                        documento</button>
                </form>
                <hr>
                <table class="table table-striped table-light mt-2 border border-dark" id="table-complements">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Parametros</th>
                            <th>Atributos</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
        var local = "http://localhost:8000"
        if (window.location.host != "localhost") {
            local = "https://caepionline.com.br"
        }

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

        function checkValid(expiration, ca) {

            return new Date().getTime() < new Date(expiration).getTime() ?
                `<span class="bg-success  mx-1 p-1">Válido</span>` :
                `<span class="bg-danger  mx-1 p-1">Inválido</span> <button id="update" class="btn btn-warning ml-2" onclick="getCA(${ca})" role="button">Atualizar</a>`
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
            url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
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
                            data: {
                                expiration: 'expiration',
                                serie: "serie"
                            },
                            render: function(data, type) {
                                return checkValid(data.expiration, data.serie)
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
                                return `<a href="${window.location.origin}/dashboard/documentos/${data}/arquivo" class="font-weight-bold btn text-danger my-0 mx-1 px-1 py-0"
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

        function getCA(ca) {
            Swal.fire({
                title: "Atualizar Documento.",
                text: "Clique em consultar base para realizar a busca dos dados",
                showLoaderOnConfirm: true,
                showCancelButton: true,
                confirmButtonText: 'Consultar base de dados',
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: () => true
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${local}/consulta/${ca}/0`,
                        method: 'GET',
                        dataType: 'json'
                    }).then(function(response) {
                        if (response.success) {
                            data = response.data.data_validade.split(" ")[0].split("/")
                            expiration = new Date(`${data[2]}-${data[1]}-${data[0]} 00:00`)

                            if (expiration > new Date()) {
                                $("#updateModal").modal("show")
                                timer = 30
                                Swal.fire({
                                    title: "Buscando Arquivo.",
                                    html: `<p>Aguarde alguns segundos enquanto realizo o download do arquivo</p><p> tempo de espera: <span id='count'>${timer} </span></p>`,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    didOpen: () => {
                                        if (response.value && response.value.success) {
                                            Swal.fire('CA encontrado com sucesso,', '',
                                                'success');
                                            response = "RegistroCA" in response.value ? response
                                                .value : response.value.data
                                            insertFormValues(response)
                                            for (key in response) {
                                                insertComplements({
                                                    "parameter": key,
                                                    "value": response[key]
                                                })
                                            }
                                            loadURLToInputFiled(
                                                `${local}/certificado/${response.value.data.numero_ca}`,
                                                `${response.value.data.numero_ca}`)

                                        } else {
                                            Swal.fire('Erro ao buscar o CA', response.value
                                                .message, 'error');
                                        }
                                        Swal.showLoading()
                                        setInterval(() => {
                                            document.getElementById("count").innerText =
                                                timer
                                            timer--
                                        }, 1000);
                                        setTimeout(() => {
                                            window.location.reload()
                                        }, (timer + 1) * 1000)

                                    }
                                })
                            }
                        }
                    });
                }
            })
        }

        // xmlHTTP return blob respond
        function getImgURL(url, ca, callback) {
            var xhr = new XMLHttpRequest();

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Código de status 2xx indica sucesso
                    callback(xhr.response);
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Arquivo localizado com sucesso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    console.error('Erro na requisição. Código de status:', xhr.status);
                }
            };

            xhr.onerror = function() {
                // Lidar com erros de rede
                Swal.fire('Erro de rede ao fazer a solicitação.');
            };

            xhr.open('GET', url);
            xhr.responseType = 'blob';

            try {
                xhr.send();
            } catch (error) {
                // Lidar com exceções durante o envio da solicitação
                Swal.fire('Erro ao enviar a solicitação:', error);
            }
        }

        function loadURLToInputFiled(url, ca) {
            getImgURL(url, ca, (imgBlob) => {

                let file = new File([imgBlob], `CA-${ca}.pdf`, {
                    type: 'application/pdf',
                    lastModified: new Date().getTime()
                }, 'utf-8');
                let container = new DataTransfer();
                container.items.add(file);
                document.querySelector('#file').files = container.files;
            });
        }
    </script>
    <script>
        $(".alert").ready(function() {
            setTimeout(() => {
                $(".alert-success").fadeOut(1000)
            }, 3000);
        })
    </script>
@endsection
