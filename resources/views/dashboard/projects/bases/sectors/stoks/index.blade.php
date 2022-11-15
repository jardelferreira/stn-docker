@extends('adminlte::page')

@section('title', 'Estoque')

@section('content_header')
    <h1>Estoque do setor -{{ $sector->name }} <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.sectors.stoks.create',$sector) }}" role="button">Adicionar ao estoque - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($stoks))
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Qtd</th>
                    <th>Certificado</th>
                    <th>NF</th>
                    {{-- <th>Ações</th> --}}
                </tr>
            </thead>
            <tbody>
                    @foreach ($stoks as $item)
                        <tr>
                            <td scope="row">{{ $item->invoiceProduct->name }}</td>
                            <td scope="row">{{ $item->invoiceProduct->description}}</td>
                            <td scope="row">{{ $item->invoiceProduct->qtd}}</td>
                            <td scope="row">{{ $item->invoiceProduct->ca_number}}</td>
                            <td scope="row">{{ $item->invoiceProduct->invoice->name}}</td>
                            {{-- <td class="btn-group" role="group">
                                <a class="btn btn-warning btn-sm mr-1"
                                    href="{{ route('dashboard.sectors.stoks.index', ['sector' => $item->id]) }}"><i
                                        class="fa fa-cubes" aria-hidden="true"></i></a>
                                <a class="btn btn-info btn-sm mr-1"
                                    href="{{ route('dashboard.sectors.edit', ['sector' => $item]) }}">Editar</a>
                                <form action="{{ route('dashboard.sectors.destroy', ['sector' => $item->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Deletar</button>
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Itens para listagem</p>
    @endif
@endsection
