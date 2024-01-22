@extends('adminlte::page')

@section('title', 'Estoque')

@section('content_header')
    <h1>Documentação vinculada - <strong>{{ $stok->invoiceProduct->name }}</strong></h1>
    <a name="addnew" id="addnew" class="btn btn-success" href="{{route('dashboard.documents.documentsAvaliable',$stok)}}" role="button">Vincular Documentos</a>
@stop

@section('content')
    @if (count($stok->documents))
        <div class="table">
            <table class="display" id="documents" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Expiração</th>
                        <th>Série</th>
                        <th>Arquivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stok->documents as $document)
                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->description }}</td>
                            <td>{{ $document->type }}</td>
                            <td>{{ $document->expiration }}</td>
                            <td>{{ $document->serie }}</td>
                            <td><a href="{{route('dashboard.documents.showFile',$document)}}" target="_blank">Ver Arquivo</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-primary" role="alert">
                <strong>Não há documentos cadastrados</strong>
            </div>
    @endif

@endsection
