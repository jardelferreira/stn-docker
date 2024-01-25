@extends('adminlte::page')

@section('title', 'Vincular documento')

@section('content_header')
    <h1>Vincular documentos para - <strong>{{ $stok->invoiceProduct->name }}</strong> - <a name="" id=""
            class="btn btn-success" href="{{ route('dashboard.documents.create') }}" role="button">Criar novo documento- <i
                class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($documents))
        <div class="table">
            <table class="display" id="documents" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Série</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <tr>
                            <td>{{ $document->name }}</td>
                            <td>{{ $document->description }}</td>
                            <td>{{ $document->serie }}</td>
                            <td>
                                <form action="{{ route('dashboard.documents.attachDocument', [$document, $stok]) }}"
                                    method="POST">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-info btn-sm" type="submit">Vincular</button>
                                </form>
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

@endsection
