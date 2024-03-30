@extends('adminlte::page')

@section('title', 'Vinculo de documento')

@section('content_header')
    <h1>Documentação vinculada - <strong>{{ $stok->invoiceProduct->name }}</strong></h1>
    <a name="addnew" id="addnew" class="btn btn-success" href="{{ route('dashboard.documents.documentsAvaliable', $stok) }}"
        role="button">Vincular Documentos</a>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close bg-dark" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Documento vinculado com sucesso!</strong> {{ session('success') }}
        </div>
    @endif
    @if (session('detach'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close bg-dark" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Desviculo! </strong> {{ session('detach') }}
        </div>
    @endif

    @if (count($documents))
        <div class="table">
            <table class="display" id="documents" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Expiração</th>
                        <th>Série</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->description }}</td>
                            <td>{{ $document->type }}</td>
                            <td>{{ $document->expiration }}</td>
                            <td>{{ $document->serie }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('dashboard.documents.showFile', $document) }}" target="_blank">Ver Arquivo</a>
                                <a class="btn btn-sm btn-danger mx-1" href="{{ route('dashboard.sectors.stoks.detachDocument',[$stok->sector_id,$stok->id, $document]) }}" target="_blank">Desvincular</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-primary" role="alert">
                <strong>Não há documentos cadastrados</strong>
            </div>
    @endif
@section('js')
    <script>
        $(".alert").ready(function() {
            setTimeout(() => {
                $(".alert").fadeOut(1000)
            }, 3000);
        })
        $.ajax({
            url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#documents').DataTable({
                    responsive: true,
                    order: [0, 'desc'],
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                });
            }
        });
    </script>
@endsection
@endsection
