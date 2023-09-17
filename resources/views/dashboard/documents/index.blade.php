@extends('adminlte::page')

@section('title', 'Documentos')

@section('content_header')
    <h1>Listagem de Documentos - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.documents.create') }}" role="button">Criar novo documento- <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    <div class="container">
        @if (count($documents))
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Tipo</th>
                        <th>Arquivo</th>
                        <th>Expiração</th>
                        <th>Série</th>
                        <th>Complementos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
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
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-primary" role="alert">
                <strong>Não há documentos cadastrados</strong>
            </div>
        @endif
    </div>
@endsection
